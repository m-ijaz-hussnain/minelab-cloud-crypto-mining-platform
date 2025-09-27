<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Lib\CurlRequest;
use App\Models\AdminNotification;
use App\Models\Badge;
use App\Models\CronJob;
use App\Models\CronJobLog;
use App\Models\Miner;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\UserBadge;
use App\Models\UserCoinBalance;
use Carbon\Carbon;

class CronController extends Controller
{
    public function cron()
    {
        $general            = gs();
        $general->last_cron = now();
        $general->save();

        $crons = CronJob::with('schedule');

        if (request()->alias) {
            $crons->where('alias', request()->alias);
        } else {
            $crons->where('next_run', '<', now())->where('is_running', Status::YES);
        }

        $crons = $crons->get();

        foreach ($crons as $cron) {
            $cronLog              = new CronJobLog();
            $cronLog->cron_job_id = $cron->id;
            $cronLog->start_at    = now();
            if ($cron->is_default) {
                $controller = new $cron->action[0];
                try {
                    $method = $cron->action[1];
                    $controller->$method();
                } catch (\Exception $e) {
                    $cronLog->error = $e->getMessage();
                }
            } else {
                try {
                    CurlRequest::curlContent($cron->url);
                } catch (\Exception $e) {
                    $cronLog->error = $e->getMessage();
                }
            }
            $cron->last_run = now();
            $cron->next_run = now()->addSeconds($cron->schedule->interval);
            $cron->save();

            $cronLog->end_at = $cron->last_run;

            $startTime         = Carbon::parse($cronLog->start_at);
            $endTime           = Carbon::parse($cronLog->end_at);
            $diffInSeconds     = $startTime->diffInSeconds($endTime);
            $cronLog->duration = $diffInSeconds;
            $cronLog->save();
        }
        if (request()->target == 'all') {
            $notify[] = ['success', 'Cron executed successfully'];
            return back()->withNotify($notify);
        }
        if (request()->alias) {
            $notify[] = ['success', keyToTitle(request()->alias) . ' executed successfully'];
            return back()->withNotify($notify);
        }
    }

    public function returnAmount()
    {
        $general            = gs();
        $general->last_cron = Carbon::now()->toDateTimeString();
        $general->save();

        $orders = Order::approved()
            ->with('user', 'miner')
            ->whereHas('user')
            ->where('period_remain', '>=', 1)
            ->where('last_paid', '<=', Carbon::now()->subHours(24)->toDateTimeString())
            ->get();

        foreach ($orders as $order) {
            $returnAmount = rand($order->min_return_per_day * 100000000, $order->max_return_per_day * 100000000) / 100000000;

            $userCoinBalance = UserCoinBalance::where('user_id', $order->user_id)->where('miner_id', $order->miner_id)->first();

            if (!$userCoinBalance) {
                continue;
            }

            $user  = $order->user;
            $miner = $order->miner;

            $boostEarningBadge = UserBadge::where('user_id', $user->id)
                ->whereNotNull('earning_boost')
                ->orderBy('sequence_number', 'DESC')
                ->first();

            if ($boostEarningBadge) {
                $boostEarningPercent = $boostEarningBadge->earning_boost;
                $boostEarningAmount  = ($returnAmount * $boostEarningPercent) / 100;
                $returnAmount += $boostEarningAmount;
            }

            //earning amount
            $userEarningAmount = $returnAmount * $miner->rate;
            $user->earning_amount += $userEarningAmount;
            $user->save();

            $userCoinBalance->balance += $returnAmount;
            $userCoinBalance->save();

            $order->period_remain -= 1;
            $order->last_paid = Carbon::now();
            $order->save();

            $trx = getTrx();

            $transaction               = new Transaction();
            $transaction->user_id      = $order->user_id;
            $transaction->amount       = $returnAmount;
            $transaction->post_balance = getAmount($userCoinBalance->balance);
            $transaction->charge       = 0;
            $transaction->trx_type     = '+';
            $transaction->details      = 'Daily return amount for the plan ' . $order->plan_details->title;
            $transaction->trx          = $trx;
            $transaction->currency     = $order->miner->coin_code;
            $transaction->remark       = 'return_amount';
            $transaction->save();

            $this->setUserBadge($user);

            $maintenanceCost = $returnAmount * $order->maintenance_cost / 100;

            $badgeForMaintenanceCostDiscount = UserBadge::where('user_id', $user->id)
                ->whereNotNull('discount_maintenance_cost')
                ->orderBy('sequence_number', 'DESC')
                ->first();

            if ($maintenanceCost && $badgeForMaintenanceCostDiscount) {
                $discountAmount = ($maintenanceCost * $badgeForMaintenanceCostDiscount->discount_maintenance_cost) / 100;
                $maintenanceCost -= $discountAmount;
            }

            if ($maintenanceCost > 0) {
                $userCoinBalance->balance -= $maintenanceCost;
                $userCoinBalance->save();

                $transaction               = new Transaction();
                $transaction->user_id      = $order->user_id;
                $transaction->amount       = $maintenanceCost;
                $transaction->post_balance = getAmount($userCoinBalance->balance);
                $transaction->charge       = 0;
                $transaction->trx_type     = '-';
                $transaction->details      = 'Deducted as maintenance charge';
                $transaction->trx          = $trx;
                $transaction->currency     = $order->miner->coin_code;
                $transaction->remark       = 'maintenance_cost';
                $transaction->save();
            }
        }
    }

    private function setUserBadge($user)
    {
        $earnedAmount = $user->earning_amount;
        $userBadges   = $user->badges()->pluck('badge_id')->toArray();

        $badges         = Badge::where('earning_amount', '<=', $earnedAmount)->whereNotIn('id', $userBadges)->orderBy('earning_amount')->get();
        $sequenceNumber = UserBadge::where('user_id', $user->id)->max('sequence_number') + 1;

        foreach ($badges as $badge) {
            $userBadge                            = new UserBadge();
            $userBadge->user_id                   = $user->id;
            $userBadge->badge_id                  = $badge->id;
            $userBadge->sequence_number           = $sequenceNumber;
            $userBadge->earning_amount            = $badge->earning_amount;
            $userBadge->discount_maintenance_cost = $badge->discount_maintenance_cost;
            $userBadge->plan_price_discount       = $badge->plan_price_discount;
            $userBadge->earning_boost             = $badge->earning_boost;
            $userBadge->referral_bonus_boost      = $badge->referral_bonus_boost;
            $userBadge->save();

            notify($user, 'USER_BADGE_UPGRADE', [
                'username'       => $user->fullname,
                'name'           => $badge->name,
                'earning_amount' => showAmount($badge->earning_amount, currencyFormat: false),
            ]);

            $sequenceNumber += 1;
        }

        if ($badges->count()) {
            $userBadges = UserBadge::where('user_id', $user->id)->orderBy('earning_amount', 'asc')->get();
            $count      = 0;
            foreach ($userBadges as $userBadge) {
                $userBadge->sequence_number = ++$count;
                $userBadge->save();
            }
        }

    }

    public function cryptoRate()
    {
        $general         = gs();
        $defaultCurrency = $general->cur_text;
        $url             = 'https://pro-api.coinmarketcap.com/v2/cryptocurrency/quotes/latest';
        $cryptos         = Miner::pluck('coin_code')->toArray();
        $cryptos         = implode(',', $cryptos);

        $parameters = [
            'symbol'  => $cryptos,
            'convert' => $defaultCurrency,
        ];

        $headers = [
            'Accepts: application/json',
            'X-CMC_PRO_API_KEY:' . trim($general->crypto_currency_api),
        ];

        $qs      = http_build_query($parameters); // query string encode the parameters
        $request = "{$url}?{$qs}"; // create the request URL
        $curl    = curl_init(); // Get cURL resource

        // Set cURL options
        curl_setopt_array($curl, array(
            CURLOPT_URL            => $request, // set the request URL
            CURLOPT_HTTPHEADER     => $headers, // set the headers
            CURLOPT_RETURNTRANSFER => 1, // ask for raw response instead of bool
        ));

        $response = curl_exec($curl); // Send the request, save the response

        curl_close($curl); // Close request
        $response = json_decode($response);

        if (@$response->status->error_message) {
            $adminNotification            = new AdminNotification();
            $adminNotification->user_id   = 0;
            $adminNotification->title     = $response->status->error_message;
            $adminNotification->click_url = '#';
            $adminNotification->save();
        }

        $coins = @$response->data ?? [];

        foreach (@$coins as $key => $coin) {
            $currency = Miner::where('coin_code', $key)->first();
            if ($currency) {
                $currency->rate = $coin[0]->quote->$defaultCurrency->price;
                $currency->save();
            }
        }
    }
}
