<?php

namespace App\Http\Controllers\Api;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\GatewayCurrency;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function methods()
    {
        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', Status::ENABLE);
        })->with('method')->orderby('method_code')->get();

        $notify[] = 'Payment methods';

        return response()->json([
            'remark' => 'deposit_methods',
            'message' => ['success' => $notify],
            'data' => [
                'methods' => $gatewayCurrency
            ],
        ]);
    }

    public function depositInsert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount'      => 'required|numeric|gt:0',
            'method_code' => 'required',
            'currency'    => 'required',
            'order'       => 'required|integer|gt:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'remark'  => 'validation_error',
                'status'  => 'error',
                'message' => ['error' => $validator->errors()->all()],
            ]);
        }


        $user = auth()->user();
        $deposit = new Deposit();
        $deposit->from_api = 1;

        $order = Order::unpaid()->find($request->order);
        if (!$order) {
            return response()->json([
                'remark' => 'validation_error',
                'status' => 'error',
                'message' => ['error' => ['Order not found']],
            ]);
        }

        $deposit->order_id = $order->id;

        $gate = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', Status::ENABLE);
        })->where('method_code', $request->method_code)->where('currency', $request->currency)->first();
        if (!$gate) {
            $notify[] = 'Invalid gateway';
            return response()->json([
                'remark'  => 'validation_error',
                'status'  => 'error',
                'message' => ['error' => $notify],
            ]);
        }

        if ($gate->min_amount > $order->amount || $gate->max_amount < $order->amount) {
            $notify[] = 'Please follow the limit';
            return response()->json([
                'remark'  => 'validation_error',
                'status'  => 'error',
                'message' => ['error' => $notify],
            ]);
        }

        $charge = $gate->fixed_charge + ($order->amount * $gate->percent_charge / 100);
        $payable = $order->amount + $charge;
        $final_amo = $payable * $gate->rate;

        $deposit->user_id = $user->id;
        $deposit->method_code = $gate->method_code;
        $deposit->method_currency = strtoupper($gate->currency);
        $deposit->amount = $order->amount;
        $deposit->charge = $charge;
        $deposit->rate = $gate->rate;
        $deposit->final_amount = $final_amo;
        $deposit->btc_amount = 0;
        $deposit->btc_wallet = "";
        $deposit->trx = getTrx();
        $deposit->success_url     = urlPath('user.plans.purchased');
        $deposit->failed_url      = urlPath('user.payment.history');
        $deposit->save();

        $notify[] =  'Payment Inserted';

        return response()->json([
            'remark' => 'payment_inserted',
            'status' => 'success',
            'message' => ['success' => $notify],
            'data' => [
                'payment' => $deposit,
                'redirect_url' => route('deposit.app.confirm', encrypt($deposit->id))
            ]
        ]);
    }
}
