<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Gateway\PaymentController;
use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\Gateway;
use App\Models\Order;
use Illuminate\Http\Request;

class ManagePaymentController extends Controller
{
    public function pending()
    {
        $pageTitle = 'Pending Payments';
        $deposits = $this->paymentData('pending');
        return view('admin.deposit.log', compact('pageTitle', 'deposits'));
    }


    public function approved()
    {
        $pageTitle = 'Approved Payments';
        $deposits = $this->paymentData('approved');
        return view('admin.deposit.log', compact('pageTitle', 'deposits'));
    }

    public function successful()
    {
        $pageTitle = 'Successful Payments';
        $deposits = $this->paymentData('successful');
        return view('admin.deposit.log', compact('pageTitle', 'deposits'));
    }

    public function rejected()
    {
        $pageTitle = 'Rejected Payments';
        $deposits = $this->paymentData('rejected');
        return view('admin.deposit.log', compact('pageTitle', 'deposits'));
    }

    public function initiated()
    {
        $pageTitle = 'Initiated Payments';
        $deposits = $this->paymentData('initiated');
        return view('admin.deposit.log', compact('pageTitle', 'deposits'));
    }

    public function payment()
    {
        $pageTitle = 'Payment History';
        $paymentData = $this->paymentData($scope = null, $summery = true);
        $deposits = $paymentData['data'];
        $summery = $paymentData['summery'];
        $successful = $summery['successful'];
        $pending = $summery['pending'];
        $rejected = $summery['rejected'];
        $initiated = $summery['initiated'];
        return view('admin.deposit.log', compact('pageTitle', 'deposits', 'successful', 'pending', 'rejected', 'initiated'));
    }

    protected function paymentData($scope = null, $summery = false)
    {
        if ($scope) {
            $deposits = Deposit::$scope()->with(['user', 'gateway']);
        } else {
            $deposits = Deposit::with(['user', 'gateway']);
        }

        $request = request();
        $deposits = $deposits->searchable(['trx', 'user:username'])->dateFilter();

        //vai method
        if ($request->method) {
            $method = Gateway::where('alias', $request->method)->firstOrFail();
            $deposits = $deposits->where('method_code', $method->code);
        }

        if (!$summery) {
            return $deposits->orderBy('id', 'desc')->paginate(getPaginate());
        } else {
            $successful = clone $deposits;
            $pending = clone $deposits;
            $rejected = clone $deposits;
            $initiated = clone $deposits;

            $successfulSummery = $successful->where('status', Status::PAYMENT_SUCCESS)->sum('amount');
            $pendingSummery    = $pending->where('status', Status::PAYMENT_PENDING)->sum('amount');
            $rejectedSummery   = $rejected->where('status', Status::PAYMENT_REJECT)->sum('amount');
            $initiatedSummery  = $initiated->where('status', Status::PAYMENT_INITIATE)->sum('amount');

            return [
                'data' => $deposits->orderBy('id', 'desc')->paginate(getPaginate()),
                'summery' => [
                    'successful' => $successfulSummery,
                    'pending' => $pendingSummery,
                    'rejected' => $rejectedSummery,
                    'initiated' => $initiatedSummery,
                ]
            ];
        }
    }

    public function details($id)
    {
        $general = gs();
        $deposit = Deposit::with(['user', 'gateway'])->findOrFail($id);
        $pageTitle = $deposit->user->username . ' paid ' . showAmount($deposit->amount);
        $details = ($deposit->detail != null) ? json_encode($deposit->detail) : null;
        return view('admin.deposit.detail', compact('pageTitle', 'deposit', 'details'));
    }


    public function approve($id)
    {
        $deposit = Deposit::where('status', Status::PAYMENT_PENDING)->findOrFail($id);

        PaymentController::userDataUpdate($deposit, true);

        $notify[] = ['success', 'Payment request approved successfully'];

        return to_route('admin.payment.pending')->withNotify($notify);
    }

    public function reject(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'message' => 'required|string|max:255'
        ]);
        $deposit = Deposit::where('status', Status::PAYMENT_PENDING)->findOrFail($request->id);

        $order = Order::pending()->find($deposit->order_id);
        if (!$order) {
            $notify[] = ['error', 'Order not found'];
            return back()->withNotify($notify);
        }
        $order->status = Status::ORDER_REJECT;
        $order->save();

        $deposit->admin_feedback = $request->message;
        $deposit->status = Status::PAYMENT_REJECT;
        $deposit->save();

        notify($deposit->user, 'PAYMENT_REJECT', [
            'plan_title' => $deposit->order->plan_details->title,
            'method_name' => $deposit->gatewayCurrency()->name,
            'method_currency' => $deposit->method_currency,
            'method_amount' => showAmount($deposit->final_amount, currencyFormat:false),
            'amount' => showAmount($deposit->amount, currencyFormat:false),
            'charge' => showAmount($deposit->charge, currencyFormat:false),
            'rate' => showAmount($deposit->rate, currencyFormat:false),
            'trx' => $deposit->trx,
            'rejection_message' => $request->message
        ]);

        $notify[] = ['success', 'Payment request rejected successfully'];
        return  to_route('admin.payment.pending')->withNotify($notify);
    }
}
