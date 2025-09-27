<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function pending()
    {
        $pageTitle   = 'Pending Withdrawals';
        $withdrawals = $this->withdrawalData('pending');
        $currencies = Withdrawal::select('currency')->distinct()->get()->pluck('currency')->toArray();
        return view('admin.withdraw.withdrawals', compact('pageTitle', 'withdrawals', 'currencies'));
    }

    public function approved()
    {
        $pageTitle   = 'Approved Withdrawals';
        $withdrawals = $this->withdrawalData('approved');
        $currencies = Withdrawal::select('currency')->distinct()->get()->pluck('currency')->toArray();
        return view('admin.withdraw.withdrawals', compact('pageTitle', 'withdrawals', 'currencies'));
    }

    public function rejected()
    {
        $pageTitle   = 'Rejected Withdrawals';
        $withdrawals = $this->withdrawalData('rejected');
        $currencies = Withdrawal::select('currency')->distinct()->get()->pluck('currency')->toArray();
        return view('admin.withdraw.withdrawals', compact('pageTitle', 'withdrawals', 'currencies'));
    }

    public function all()
    {
        $pageTitle      = 'All Withdrawals';
        $withdrawalData = $this->withdrawalData($scope = null, $summery = true);
        $currencies = Withdrawal::select('currency')->distinct()->get()->pluck('currency')->toArray();
        $withdrawals    = $withdrawalData['data'];
        $summery        = $withdrawalData['summery'];
        $successful     = $summery['successful'];
        $pending        = $summery['pending'];
        $rejected       = $summery['rejected'];

        return view('admin.withdraw.withdrawals', compact('pageTitle', 'withdrawals', 'successful', 'pending', 'rejected', 'currencies'));
    }

    protected function withdrawalData($scope = null, $summery = false)
    {
        if ($scope) {
            $withdrawals = Withdrawal::$scope();
        } else {
            $withdrawals = Withdrawal::where('status', '!=', Status::PAYMENT_INITIATE);
        }

        $withdrawals = $withdrawals->searchable(['trx', 'user:username'])->dateFilter()->filter(['currency']);

        if (!$summery) {
            return $withdrawals->with(['user', 'userCoinBalance.miner'])->orderBy('id', 'desc')->paginate(getPaginate());
        } else {

            $successful = clone $withdrawals;
            $pending    = clone $withdrawals;
            $rejected   = clone $withdrawals;

            $successfulSummery = $successful->where('status', Status::PAYMENT_SUCCESS)->sum('amount');
            $pendingSummery    = $pending->where('status', Status::PAYMENT_PENDING)->sum('amount');
            $rejectedSummery   = $rejected->where('status', Status::PAYMENT_REJECT)->sum('amount');

            return [
                'data'    => $withdrawals->with(['user', 'userCoinBalance.miner'])->orderBy('id', 'desc')->paginate(getPaginate()),
                'summery' => [
                    'successful' => $successfulSummery,
                    'pending'    => $pendingSummery,
                    'rejected'   => $rejectedSummery,
                ],
            ];
        }
    }

    public function details($id)
    {
        $general    = gs();
        $withdrawal = Withdrawal::where('status', '!=', Status::PAYMENT_INITIATE)->with(['user', 'userCoinBalance.miner'])->findOrFail($id);
        $pageTitle = 'Withdrawal Details';
        $details    = $withdrawal->withdraw_information ? json_encode($withdrawal->withdraw_information) : null;
        return view('admin.withdraw.detail', compact('pageTitle', 'withdrawal', 'details'));
    }

    public function approve(Request $request)
    {
        $request->validate(['id' => 'required|integer']);

        $withdraw = Withdrawal::where('status', Status::PAYMENT_PENDING)->with('user', 'userCoinBalance.miner')->findOrFail($request->id);

        $withdraw->status         = Status::PAYMENT_SUCCESS;
        $withdraw->admin_feedback = $request->details;
        $withdraw->save();

        notify($withdraw->user, 'WITHDRAW_APPROVE', [
            'wallet'         => $withdraw->userCoinBalance->wallet,
            'amount'         => showAmount($withdraw->amount, 8, exceptZeros: true, currencyFormat: false),
            'coin_code'      => $withdraw->userCoinBalance->miner->coin_code,
            'trx'            => $withdraw->trx,
            'admin_feedback' => $withdraw->admin_feedback,
        ]);

        $notify[] = ['success', 'Withdrawal approved successfully'];
        return to_route('admin.withdraw.data.pending')->withNotify($notify);
    }

    public function reject(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $withdraw = Withdrawal::where('status', Status::PAYMENT_PENDING)->with('user', 'userCoinBalance.miner')->findOrFail($request->id);
        $wallet   = $withdraw->userCoinBalance;

        $user = User::find($withdraw->user_id);

        $withdraw->status         = Status::PAYMENT_REJECT;
        $withdraw->admin_feedback = $request->details;
        $withdraw->save();

        $wallet->increment('balance', $withdraw->amount);

        $transaction               = new Transaction();
        $transaction->user_id      = $withdraw->user_id;
        $transaction->amount       = $withdraw->amount;
        $transaction->post_balance = $wallet->balance;
        $transaction->currency     = $wallet->miner->coin_code;
        $transaction->charge       = 0;
        $transaction->trx_type     = '+';
        $transaction->remark       = 'withdraw_reject';
        $transaction->details      = showAmount($withdraw->amount, 8, exceptZeros: true, currencyFormat: false) . ' ' . $wallet->miner->coin_code . ' Refunded from withdrawal rejection';
        $transaction->trx          = $withdraw->trx;
        $transaction->save();

        notify($user, 'WITHDRAW_REJECT', [
            'wallet'         => $wallet->wallet,
            'amount'         => showAmount($withdraw->amount, 8, exceptZeros: true, currencyFormat: false),
            'post_balance'   => showAmount($transaction->post_balance, 8, exceptZeros: true, currencyFormat: false),
            'coin_code'      => $wallet->miner->coin_code,
            'trx'            => $withdraw->trx,
            'admin_feedback' => $withdraw->admin_feedback,
        ]);

        $notify[] = ['success', 'Withdrawal rejected successfully'];
        return to_route('admin.withdraw.data.pending')->withNotify($notify);
    }
}
