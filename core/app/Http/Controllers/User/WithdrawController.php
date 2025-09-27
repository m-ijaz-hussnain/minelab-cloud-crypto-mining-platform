<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\Transaction;
use App\Models\UserCoinBalance;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{

    public function withdrawMoney()
    {
        $withdrawMethod = UserCoinBalance::where('user_id', auth()->id())->with('miner')->get();
        $pageTitle = 'Withdraw Money';
        return view('Template::user.withdraw.methods', compact('pageTitle', 'withdrawMethod'));
    }

    public function withdrawStore(Request $request)
    {
        $request->validate([
            'id'     => 'required|integer|gt:0',
            'amount' => 'required|numeric'
        ]);

        $user   = auth()->user();
        $wallet = UserCoinBalance::where('user_id', $user->id)->with('miner')->findOrFail($request->id);

        $minLimit = getAmount($wallet->miner->min_withdraw_limit, 8);
        $maxLimit = getAmount($wallet->miner->max_withdraw_limit, 8);

        $request->validate([
            'amount'    => "numeric|min:$minLimit|max:$maxLimit"
        ]);

        if ($wallet->balance < $request->amount) {
            $notify[] = ['error', 'Insufficient balance'];
            return back()->withNotify($notify);
        }

        if (!$wallet->wallet) {
            $notify[] = ['error', 'No wallet address was provided for this coin.'];
            $notify[] = ['info', 'Kindly update your wallet address.'];
            return back()->withNotify($notify);
        }



        $withdraw                           = new Withdrawal();
        $withdraw->user_coin_balance_id     = $request->id;
        $withdraw->user_id                  = $user->id;
        $withdraw->amount                   = $request->amount;
        $withdraw->trx                      = getTrx();
        $withdraw->currency                 = $wallet->miner->coin_code;
        $withdraw->final_amount             = $request->amount;
        $withdraw->after_charge             = $request->amount;
        $withdraw->status                   = Status::PAYMENT_PENDING;
        $withdraw->save();


        $adminNotification            = new AdminNotification();
        $adminNotification->user_id   = $user->id;
        $adminNotification->title     = 'New withdraw request from ' . $user->username;
        $adminNotification->click_url = urlPath('admin.withdraw.data.details', $withdraw->id);
        $adminNotification->save();

        //Decrease the Balance
        $wallet->decrement('balance', $request->amount);

        $transaction               = new Transaction();
        $transaction->user_id      = $withdraw->user_id;
        $transaction->currency     = $wallet->miner->coin_code;
        $transaction->amount       = $withdraw->amount;
        $transaction->post_balance = $wallet->balance;
        $transaction->trx_type     = '-';
        $transaction->details      = showAmount($withdraw->amount, 8, exceptZeros: true, currencyFormat: false) . ' ' . $wallet->miner->coin_code . ' withdrawn to wallet address: ' . $wallet->wallet;
        $transaction->trx          = $withdraw->trx;
        $transaction->remark       = 'withdraw';
        $transaction->save();

        notify($user, 'WITHDRAW_REQUEST', [
            'wallet'        => $wallet->wallet,
            'post_balance'  => showAmount($wallet->balance, 8, exceptZeros: true, currencyFormat: false),
            'amount'        => showAmount($withdraw->amount, 8, exceptZeros: true, currencyFormat: false),
            'coin_code'     => $wallet->miner->coin_code,
            'trx'           => $withdraw->trx

        ]);

        $notify[] = ['success', 'Withdrawal request successfully submitted'];

        return to_route('user.withdraw.preview', encrypt($withdraw->id))->withNotify($notify);
    }

    public function withdrawPreview($id)
    {
        try {
            $id = decrypt($id);
        } catch (\Throwable $th) {
            abort('404');
        }
        $withdraw = Withdrawal::with('user')->where('status', Status::PAYMENT_PENDING)->orderBy('id', 'desc')->findOrFail($id);
        $pageTitle = 'Withdraw Preview';
        return view('Template::user.withdraw.preview', compact('pageTitle', 'withdraw'));
    }

    public function withdrawLog()
    {
        $pageTitle = "My Withdrawals";
        $withdraws = Withdrawal::where('user_id', auth()->id());

        if (request()->search) {
            $withdraws = $withdraws->where(function ($query) {
                $query->where('trx', request()->search)->orWhereHas('userCoinBalance', function ($query) {
                    $query->where('wallet', 'like', '%' . request()->search . '%');
                });
            });
        }

        $withdraws = $withdraws->with('userCoinBalance.miner')->orderBy('id', 'desc')->paginate(getPaginate());

        return view('Template::user.withdraw.log', compact('pageTitle', 'withdraws'));
    }
}
