<?php

namespace App\Http\Controllers\Api;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\Transaction;
use App\Models\UserCoinBalance;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WithdrawController extends Controller
{
    public function withdrawMethod()
    {
        $withdrawMethod = UserCoinBalance::where('user_id', auth()->id())->with('miner')->get();
        $notify[] = 'Withdrawals methods';

        return response()->json([
            'remark' => 'withdraw_methods',
            'status' => 'success',
            'message' => ['success' => $notify],
            'data' => [
                'withdrawMethod' => $withdrawMethod
            ]
        ]);
    }

    public function withdrawStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'wallet_id'     => 'required|integer|gt:0',
            'amount' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return $this->errorMessage($validator->errors()->all());
        }

        $wallet   = UserCoinBalance::with('miner')->find($request->wallet_id);

        if (!$wallet) {
            $notify[] = ['error', 'Wallet not found'];
            return $this->errorMessage($validator->errors()->all());
        }

        $minLimit  = getAmount($wallet->miner->min_withdraw_limit, 8);
        $maxLimit  = getAmount($wallet->miner->max_withdraw_limit, 8);

        $validator = Validator::make($request->all(), [
            'amount'   => "numeric|min:$minLimit|max:$maxLimit"
        ]);

        if ($validator->fails()) {
            return $this->errorMessage($validator->errors()->all());
        }

        if ($wallet->balance < $request->amount) {
            $notify[] = ['error', 'Insufficient balance'];
            return $this->errorMessage($notify);
        }

        if (!$wallet->wallet) {
            $notify[] = ['error', 'You didn\'t provide any wallet address for this coin. Please update your wallet address'];
            return $this->errorMessage($notify);
        }

        $user = auth()->user();

        $withdraw                           = new Withdrawal();
        $withdraw->user_coin_balance_id     = $request->wallet_id;
        $withdraw->user_id                  = $user->id;
        $withdraw->amount                   = getAmount($request->amount);
        $withdraw->trx                      = getTrx();
        $withdraw->currency                 = $wallet->miner->coin_code;
        $withdraw->final_amount             = getAmount($request->amount);
        $withdraw->after_charge             = getAmount($request->amount);
        $withdraw->status                   = Status::PAYMENT_PENDING;
        $withdraw->save();


        $adminNotification            = new AdminNotification();
        $adminNotification->user_id   = $user->id;
        $adminNotification->title     = 'New withdraw request from ' . $user->username;
        $adminNotification->click_url = urlPath('admin.withdraw.data.details', $withdraw->id);
        $adminNotification->save();

        //Decrease the Balance
        $wallet->decrement('balance', $request->amount);

        $transaction                = new Transaction();
        $transaction->user_id       = $withdraw->user_id;
        $transaction->currency      = $wallet->miner->coin_code;
        $transaction->amount        = getAmount($withdraw->amount);
        $transaction->post_balance  = getAmount($wallet->balance);
        $transaction->trx_type      = '-';
        $transaction->details       = getAmount($withdraw->amount) . ' ' . $wallet->miner->coin_code . ' Withdraw Via Wallet Id: ' . $wallet->wallet;
        $transaction->trx           =  $withdraw->trx;
        $transaction->remark        =  'withdraw';
        $transaction->save();

        notify($user, 'WITHDRAW_REQUEST', [
            'wallet'        => $wallet->wallet,
            'post_balance'  => showAmount($wallet->balance, currencyFormat: false),
            'amount'        => showAmount($withdraw->amount, currencyFormat: false),
            'coin_code'     => $wallet->miner->coin_code,
            'trx'           => $withdraw->trx

        ]);

        return response()->json([
            'remark' => 'withdraw_request',
            'status' => 'success',
            'message' => ['success' => 'Withdrawal request successfully submitted'],
            'data' => [
                'amount'       => $withdraw->amount,
                'trx'          => $withdraw->trx,
                'post_balance' => $transaction->post_balance,
                'status'       => $withdraw->status
            ]
        ]);
    }

    public function withdrawLog(Request $request)
    {
        $withdraws = Withdrawal::where('user_id', auth()->id());

        if ($request->search) {
            $search = $request->search;
            $withdraws = $withdraws->where(function ($query) use ($search) {
                $query->where('trx', request()->search)->orWhereHas('userCoinBalance', function ($query) use ($search) {
                    $query->where('wallet', 'like', '%' . $search . '%');
                });
            });
        }

        $withdraws = $withdraws->select('id', 'user_id', 'user_coin_balance_id', 'amount', 'currency', 'trx', 'final_amount', 'status', 'admin_feedback', 'created_at')->with('userCoinBalance:id,user_id,miner_id,wallet,balance', 'userCoinBalance.miner')->orderBy('id', 'desc')->paginate(getPaginate());

        $notify[] = 'Withdraw Log';
        return response()->json([
            'remark'  => 'withdraw_log',
            'status'  => 'success',
            'message' => ['success' => $notify],
            'data'    => [
                'withdraws' => $withdraws
            ]
        ]);
    }

    protected function errorMessage($error, $remark = 'validation_error')
    {
        return response()->json([
            'remark'  => $remark,
            'status'  => 'error',
            'message' => ['error' => $error]
        ]);
    }
}
