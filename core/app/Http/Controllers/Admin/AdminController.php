<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Lib\CurlRequest;
use App\Models\AdminNotification;
use App\Models\Deposit;
use App\Models\Miner;
use App\Models\Order;
use App\Models\Plan;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserLogin;
use App\Models\Withdrawal;
use App\Rules\FileTypeValidate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    public function dashboard()
    {
        $pageTitle = 'Dashboard';
        $oq        = Order::whereNotIn('status', [Status::ORDER_UNPAID, Status::ORDER_REJECT]);
        
        // User Info
        $widget['total_users']             = User::count();
        $widget['verified_users']          = User::active()->count();
        $widget['email_unverified_users']  = User::emailUnverified()->count();
        $widget['mobile_unverified_users'] = User::mobileUnverified()->count();
        $widget['total_miner']             = Miner::count();
        $widget['total_plan']              = Plan::count();
        $widget['total_sale_count']        = $oq->count();
        $widget['total_sale_amount']       = $oq->sum('amount');

        $transactionCurrencies = Transaction::groupBy('currency')->orderBy('currency')->pluck('currency')->toArray();
        $coinCodes             = Transaction::where('remark', 'return_amount')->groupBy('currency')->orderBy('currency')->pluck('currency')->toArray();

        // user Browsing, Country, Operating Log
        $userLoginData = UserLogin::where('created_at', '>=', Carbon::now()->subDays(30))->get(['browser', 'os', 'country']);

        $chart['user_browser_counter'] = $userLoginData->groupBy('browser')->map(function ($item, $key) {
            return collect($item)->count();
        });
        $chart['user_os_counter'] = $userLoginData->groupBy('os')->map(function ($item, $key) {
            return collect($item)->count();
        });
        $chart['user_country_counter'] = $userLoginData->groupBy('country')->map(function ($item, $key) {
            return collect($item)->count();
        })->sort()->reverse()->take(5);

        $withdrawals['total_withdraw_amount']   = Withdrawal::approved()->sum('amount');
        $withdrawals['total_withdraw_pending']  = Withdrawal::pending()->count();
        $withdrawals['total_withdraw_rejected'] = Withdrawal::rejected()->count();
        $withdrawals['total_withdraw_charge']   = Withdrawal::approved()->sum('charge');

        return view('admin.dashboard', compact('pageTitle', 'widget', 'chart', 'withdrawals', 'transactionCurrencies', 'coinCodes'));
    }

    public function transactionReport(Request $request)
    {

        $diffInDays = Carbon::parse($request->start_date)->diffInDays(Carbon::parse($request->end_date));

        $groupBy = $diffInDays > 30 ? 'months' : 'days';
        $format = $diffInDays > 30 ? '%M-%Y'  : '%d-%M-%Y';

        $currency = $request->currency;

        if ($groupBy == 'days') {
            $dates = $this->getAllDates($request->start_date, $request->end_date);
        } else {
            $dates = $this->getAllMonths($request->start_date, $request->end_date);
        }

        $plusTransactions   = Transaction::where('trx_type', '+')
            ->where('currency', $currency)
            ->whereDate('created_at', '>=', $request->start_date)
            ->whereDate('created_at', '<=', $request->end_date)
            ->selectRaw('SUM(amount) AS amount')
            ->selectRaw("DATE_FORMAT(created_at, '{$format}') as created_on")
            ->latest()
            ->groupBy('created_on')
            ->get();

        $minusTransactions  = Transaction::where('trx_type', '-')
            ->where('currency', $currency)
            ->whereDate('created_at', '>=', $request->start_date)
            ->whereDate('created_at', '<=', $request->end_date)
            ->selectRaw('SUM(amount) AS amount')
            ->selectRaw("DATE_FORMAT(created_at, '{$format}') as created_on")
            ->latest()
            ->groupBy('created_on')
            ->get();


        $data = [];

        foreach ($dates as $date) {
            $data[] = [
                'created_on' => $date,
                'credits' => getAmount($plusTransactions->where('created_on', $date)->first()?->amount ?? 0),
                'debits' => getAmount($minusTransactions->where('created_on', $date)->first()?->amount ?? 0)
            ];
        }

        $data = collect($data);

        $report['created_on']   = $data->pluck('created_on');
        $report['data']     = [
            [
                'name' => 'Plus Transactions',
                'data' => $data->pluck('credits')
            ],
            [
                'name' => 'Minus Transactions',
                'data' => $data->pluck('debits')
            ]
        ];

        return response()->json($report);
    }

    public function returnAmountReport(Request $request)
    {
        $diffInDays = Carbon::parse($request->start_date)->diffInDays(Carbon::parse($request->end_date));

        $groupBy = $diffInDays > 30 ? 'months' : 'days';
        $format = $diffInDays > 30 ? '%M-%Y'  : '%d-%M-%Y';

        $currency = $request->currency;

        if ($groupBy == 'days') {
            $dates = $this->getAllDates($request->start_date, $request->end_date);
        } else {
            $dates = $this->getAllMonths($request->start_date, $request->end_date);
        }

        $transactions   = Transaction::where('trx_type', '+')
            ->where('currency', $currency)
            ->where('remark', 'return_amount')
            ->whereDate('created_at', '>=', $request->start_date)
            ->whereDate('created_at', '<=', $request->end_date)
            ->selectRaw('SUM(amount) AS amount')
            ->selectRaw("DATE_FORMAT(created_at, '{$format}') as created_on")
            ->latest()
            ->groupBy('created_on')
            ->get();


        $data = [];

        foreach ($dates as $date) {
            $data[] = [
                'created_on' => $date,
                'returnAmount' => getAmount($transactions->where('created_on', $date)->first()?->amount ?? 0),
            ];
        }

        $data = collect($data);

        // Monthly Deposit & Withdraw Report Graph
        $report['currency'] = $currency;
        $report['created_on']   = $data->pluck('created_on');
        $report['data']     = [
            [
                'name' => 'Returned Amount',
                'data' => $data->pluck('returnAmount')
            ]
        ];

        return response()->json($report);
    }


    private function getAllDates($startDate, $endDate)
    {
        $dates = [];
        $currentDate = new \DateTime($startDate);
        $endDate = new \DateTime($endDate);

        while ($currentDate <= $endDate) {
            $dates[] = $currentDate->format('d-F-Y');
            $currentDate->modify('+1 day');
        }

        return $dates;
    }

    private function  getAllMonths($startDate, $endDate)
    {
        if ($endDate > now()) {
            $endDate = now()->format('Y-m-d');
        }

        $startDate = new \DateTime($startDate);
        $endDate = new \DateTime($endDate);

        $months = [];

        while ($startDate <= $endDate) {
            $months[] = $startDate->format('F-Y');
            $startDate->modify('+1 month');
        }

        return $months;
    }


    public function profile()
    {
        $pageTitle = 'Profile';
        $admin = auth('admin')->user();
        return view('admin.profile', compact('pageTitle', 'admin'));
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'image' => ['nullable', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])]
        ]);
        $user = auth('admin')->user();

        if ($request->hasFile('image')) {
            try {
                $old = $user->image;
                $user->image = fileUploader($request->image, getFilePath('adminProfile'), getFileSize('adminProfile'), $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        $notify[] = ['success', 'Profile updated successfully'];
        return to_route('admin.profile')->withNotify($notify);
    }

    public function password()
    {
        $pageTitle = 'Password Setting';
        $admin = auth('admin')->user();
        return view('admin.password', compact('pageTitle', 'admin'));
    }

    public function passwordUpdate(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|min:5|confirmed',
        ]);

        $user = auth('admin')->user();
        if (!Hash::check($request->old_password, $user->password)) {
            $notify[] = ['error', 'Password doesn\'t match!!'];
            return back()->withNotify($notify);
        }
        $user->password = Hash::make($request->password);
        $user->save();
        $notify[] = ['success', 'Password changed successfully.'];
        return to_route('admin.password')->withNotify($notify);
    }

    public function notifications()
    {
        $notifications = AdminNotification::orderBy('id', 'desc')->with('user')->paginate(getPaginate());
        $hasUnread = AdminNotification::where('is_read', Status::NO)->exists();
        $hasNotification = AdminNotification::exists();
        $pageTitle = 'Notifications';
        return view('admin.notifications', compact('pageTitle', 'notifications', 'hasUnread', 'hasNotification'));
    }


    public function notificationRead($id)
    {
        $notification = AdminNotification::findOrFail($id);
        $notification->is_read = Status::YES;
        $notification->save();
        $url = $notification->click_url;
        if ($url == '#') {
            $url = url()->previous();
        }
        return redirect($url);
    }

    public function requestReport()
    {
        $pageTitle = 'Your Listed Report & Request';
        $arr['app_name'] = systemDetails()['name'];
        $arr['app_url'] = env('APP_URL');
        $arr['purchase_code'] = env('PURCHASECODE');
        $url = "https://license.viserlab.com/issue/get?" . http_build_query($arr);
        $response = CurlRequest::curlContent($url);
        $response = json_decode($response);
        if (!$response || !@$response->status || !@$response->message) {
            return to_route('admin.dashboard')->withErrors('Something went wrong');
        }
        if ($response->status == 'error') {
            return to_route('admin.dashboard')->withErrors($response->message);
        }
        $reports = $response->message[0];
        return view('admin.reports', compact('reports', 'pageTitle'));
    }

    public function reportSubmit(Request $request)
    {
        $request->validate([
            'type' => 'required|in:bug,feature',
            'message' => 'required',
        ]);
        $url = 'https://license.viserlab.com/issue/add';

        $arr['app_name'] = systemDetails()['name'];
        $arr['app_url'] = env('APP_URL');
        $arr['purchase_code'] = env('PURCHASECODE');
        $arr['req_type'] = $request->type;
        $arr['message'] = $request->message;
        $response = CurlRequest::curlPostContent($url, $arr);
        $response = json_decode($response);
        if (!$response || !@$response->status || !@$response->message) {
            return to_route('admin.dashboard')->withErrors('Something went wrong');
        }
        if ($response->status == 'error') {
            return back()->withErrors($response->message);
        }
        $notify[] = ['success', $response->message];
        return back()->withNotify($notify);
    }

    public function readAllNotification()
    {
        AdminNotification::where('is_read', Status::NO)->update([
            'is_read' => Status::YES
        ]);
        $notify[] = ['success', 'Notifications read successfully'];
        return back()->withNotify($notify);
    }

    public function deleteAllNotification()
    {
        AdminNotification::truncate();
        $notify[] = ['success', 'Notifications deleted successfully'];
        return back()->withNotify($notify);
    }

    public function deleteSingleNotification($id)
    {
        AdminNotification::where('id', $id)->delete();
        $notify[] = ['success', 'Notification deleted successfully'];
        return back()->withNotify($notify);
    }

    public function downloadAttachment($fileHash)
    {
        $filePath = decrypt($fileHash);
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $title = slug(gs('site_name')) . '- attachments.' . $extension;
        try {
            $mimetype = mime_content_type($filePath);
        } catch (\Exception $e) {
            $notify[] = ['error', 'File does not exists'];
            return back()->withNotify($notify);
        }
        header('Content-Disposition: attachment; filename="' . $title);
        header("Content-Type: " . $mimetype);
        return readfile($filePath);
    }

    public function getChartData(Request $request)
    {
        if ($request->ajax()) {
            $currency = request()->currency;

            if ($request->type == 'transaction') {
                $trxReport['date']             = collect([]);
                $trxReport['plus_trx_amount']  = collect([]);
                $trxReport['minus_trx_amount'] = collect([]);
                $plusTrx                       = Transaction::where('trx_type', '+')->where('created_at', '>=', Carbon::now()->subDays(30))
                    ->where('currency', $currency)
                    ->selectRaw("SUM(amount) as amount, DATE_FORMAT(created_at,'%Y-%m-%d') as date")
                    ->orderBy('created_at')
                    ->groupBy('date')
                    ->get();

                $plusTrx->map(function ($trxData) use ($trxReport) {
                    $trxReport['date']->push($trxData->date);
                });

                $minusTrx = Transaction::where('trx_type', '-')->where('created_at', '>=', Carbon::now()->subDays(30))
                    ->where('currency', $currency)
                    ->selectRaw("SUM(amount) as amount, DATE_FORMAT(created_at,'%Y-%m-%d') as date")
                    ->orderBy('created_at')
                    ->groupBy('date')
                    ->get();

                $minusTrx->map(function ($trxData) use ($trxReport) {
                    $trxReport['date']->push($trxData->date);
                });

                $trxReport['date'] = dateSorting($trxReport['date']->unique()->toArray());

                foreach ($trxReport['date'] as $trxDate) {
                    $trxReport['plus_trx_amount']->push(getAmount(@$plusTrx->where('date', $trxDate)->first()->amount));
                    $trxReport['minus_trx_amount']->push(getAmount(@$minusTrx->where('date', $trxDate)->first()->amount));
                }

                $trxReport['plus_trx_amount']  = $trxReport['plus_trx_amount']->toArray();
                $trxReport['minus_trx_amount'] = $trxReport['minus_trx_amount']->toArray();

                return response()->json(['trxReport' => $trxReport, 'currency' => strtoupper($currency)]);
            }

            if ($request->type == 'return_amount') {
                $trxReport['months'] = collect([]);
                $trxReport['amount'] = collect([]);
                $transactions        = Transaction::where('trx_type', '+')->where('created_at', '>=', Carbon::now()->subYear())
                    ->where('currency', $currency)
                    ->selectRaw("SUM(amount) as amount")
                    ->selectRaw("DATE_FORMAT(created_at,'%M-%Y') as months")
                    ->orderBy('months')
                    ->groupBy('months')
                    ->get();

                $transactions->map(function ($trxData) use ($trxReport) {
                    $trxReport['months']->push($trxData->months);
                });

                $months = $trxReport['months'];
                for ($i = 0; $i < $months->count(); ++$i) {
                    $monthVal = Carbon::parse($months[$i]);
                    for ($j = $i + 1; $j < $months->count(); $j++) {
                        if (isset($months[$j])) {
                            $dateValNext = Carbon::parse($months[$j]);
                            if ($dateValNext < $monthVal) {
                                $temp       = $months[$i];
                                $months[$i] = Carbon::parse($months[$j])->format('F-Y');
                                $months[$j] = Carbon::parse($temp)->format('F-Y');
                            } else {
                                $months[$i] = Carbon::parse($months[$i])->format('F-Y');
                            }
                        }
                    }
                }

                foreach ($months as $month) {
                    $trxReport['amount']->push(getAmount(@$transactions->where('months', $month)->first()->amount));
                }

                $trxReport['amount'] = $trxReport['amount']->toArray();

                return response()->json(['trxReport' => $trxReport, 'currency' => strtoupper($currency), 'months' => $months]);
            }
        }
    }
}
