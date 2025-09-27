<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Lib\FormProcessor;
use App\Lib\GoogleAuthenticator;
use App\Models\Deposit;
use App\Models\DeviceToken;
use App\Models\Form;
use App\Models\Miner;
use App\Models\Referral;
use App\Models\ReferralLog;
use App\Models\Transaction;
use App\Models\UserCoinBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function home()
    {
        $pageTitle     = 'Dashboard';
        $user          = auth()->user();
        $referralBonus = ReferralLog::where('referee_id', $user->id)->sum('amount');

        $miners = Miner::with(['userCoinBalances' => function ($q) {
            return $q->where('user_id', auth()->id());
        }])->whereHas('userCoinBalances', function ($q) {
            return $q->where('user_id', auth()->id());
        })->get();

        $transactions = Transaction::where('user_id', $user->id)->orderBy('id', 'desc')->limit(10)->get();

        return view('Template::user.dashboard', compact('pageTitle', 'referralBonus', 'miners', 'transactions', 'user'));
    }

    public function paymentHistory(Request $request)
    {
        $pageTitle = 'Payment History';
        $user = auth()->user();
        $deposits = Deposit::where('user_id', $user->id)->searchable(['trx'])->with(['gateway'])->orderBy('id', 'desc')->paginate(getPaginate());
        return view('Template::user.payment_history', compact('pageTitle', 'deposits'));
    }

    public function show2faForm()
    {
        $ga = new GoogleAuthenticator();
        $user = auth()->user();
        $secret = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($user->username . '@' . gs('site_name'), $secret);
        $pageTitle = '2FA Security';
        return view('Template::user.twofactor', compact('pageTitle', 'secret', 'qrCodeUrl'));
    }

    public function create2fa(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'key' => 'required',
            'code' => 'required',
        ]);
        $response = verifyG2fa($user, $request->code, $request->key);
        if ($response) {
            $user->tsc = $request->key;
            $user->ts = Status::ENABLE;
            $user->save();
            $notify[] = ['success', 'Two factor authenticator activated successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong verification code'];
            return back()->withNotify($notify);
        }
    }

    public function disable2fa(Request $request)
    {
        $request->validate([
            'code' => 'required',
        ]);

        $user = auth()->user();
        $response = verifyG2fa($user, $request->code);
        if ($response) {
            $user->tsc = null;
            $user->ts = Status::DISABLE;
            $user->save();
            $notify[] = ['success', 'Two factor authenticator deactivated successfully'];
        } else {
            $notify[] = ['error', 'Wrong verification code'];
        }
        return back()->withNotify($notify);
    }


    public function transactions(Request $request)
    {
        $pageTitle    = 'Transactions';
        $remarks      = Transaction::distinct('remark')->orderBy('remark')->get('remark');
        $coins        = Transaction::distinct('currency')->orderBy('currency')->get('currency');
        $transactions = Transaction::where('user_id', auth()->id());

        if ($request->search) {
            $transactions = $transactions->where('trx', $request->search);
        }

        if ($request->type) {
            $transactions = $transactions->where('trx_type', $request->type);
        }

        if ($request->remark) {
            $transactions = $transactions->where('remark', $request->remark);
        }

        if ($request->coin_code) {
            $transactions = $transactions->where('currency', $request->coin_code);
        }

        $transactions = $transactions->orderBy('id', 'desc')->paginate(getPaginate());
        return view('Template::user.transactions', compact('pageTitle', 'transactions', 'remarks', 'coins'));
    }

    public function kycForm()
    {
        if (auth()->user()->kv == Status::KYC_PENDING) {
            $notify[] = ['error', 'Your KYC is under review'];
            return to_route('user.home')->withNotify($notify);
        }
        if (auth()->user()->kv == Status::KYC_VERIFIED) {
            $notify[] = ['error', 'You are already KYC verified'];
            return to_route('user.home')->withNotify($notify);
        }
        $pageTitle = 'KYC Form';
        $form = Form::where('act', 'kyc')->first();
        return view('Template::user.kyc.form', compact('pageTitle', 'form'));
    }

    public function kycData()
    {
        $user = auth()->user();
        $pageTitle = 'KYC Data';
        abort_if($user->kv == Status::VERIFIED,403);
        return view('Template::user.kyc.info', compact('pageTitle', 'user'));
    }

    public function kycSubmit(Request $request)
    {
        $form = Form::where('act', 'kyc')->firstOrFail();
        $formData = $form->form_data;
        $formProcessor = new FormProcessor();
        $validationRule = $formProcessor->valueValidation($formData);
        $request->validate($validationRule);
        $user = auth()->user();
        foreach (@$user->kyc_data ?? [] as $kycData) {
            if ($kycData->type == 'file') {
                fileManager()->removeFile(getFilePath('verify') . '/' . $kycData->value);
            }
        }
        $userData = $formProcessor->processFormData($request, $formData);
        $user->kyc_data = $userData;
        $user->kyc_rejection_reason = null;
        $user->kv = Status::KYC_PENDING;
        $user->save();

        $notify[] = ['success', 'KYC data submitted successfully'];
        return to_route('user.home')->withNotify($notify);
    }

    public function userData()
    {
        $user = auth()->user();

        if ($user->profile_complete == Status::YES) {
            return to_route('user.home');
        }

        $pageTitle  = 'User Data';
        $info       = json_decode(json_encode(getIpInfo()), true);
        $mobileCode = @implode(',', $info['code']);
        $countries  = json_decode(file_get_contents(resource_path('views/partials/country.json')));

        return view('Template::user.user_data', compact('pageTitle', 'user', 'countries', 'mobileCode'));
    }

    public function userDataSubmit(Request $request)
    {
        $user = auth()->user();

        if ($user->profile_complete == Status::YES) {
            return to_route('user.home');
        }

        $countryData  = (array)json_decode(file_get_contents(resource_path('views/partials/country.json')));
        $countryCodes = implode(',', array_keys($countryData));
        $mobileCodes  = implode(',', array_column($countryData, 'dial_code'));
        $countries    = implode(',', array_column($countryData, 'country'));

        $request->validate([
            'country_code' => 'required|in:' . $countryCodes,
            'country'      => 'required|in:' . $countries,
            'mobile_code'  => 'required|in:' . $mobileCodes,
            'username'     => 'required|unique:users|min:6',
            'mobile'       => ['required', 'regex:/^([0-9]*)$/', Rule::unique('users')->where('dial_code', $request->mobile_code)],
        ]);

        if (preg_match("/[^a-z0-9_]/", trim($request->username))) {
            $notify[] = ['info', 'Username can contain only small letters, numbers and underscore.'];
            $notify[] = ['error', 'No special character, space or capital letters in username.'];
            return back()->withNotify($notify)->withInput($request->all());
        }

        $user->country_code = $request->country_code;
        $user->mobile       = $request->mobile;
        $user->username     = $request->username;

        $user->address = $request->address;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->zip = $request->zip;
        $user->country_name = @$request->country;
        $user->dial_code = $request->mobile_code;

        $user->profile_complete = Status::YES;
        $user->save();

        return to_route('user.home');
    }

    public function referral()
    {
        $general = gs();

        if (!$general->referral_system) {
            $notify[] = ['error', 'Sorry, the referral system is currently unavailable'];
            return back()->withNotify($notify);
        }

        $pageTitle = "Referrals";
        $maxLevel  = Referral::max('level');
        $relations = [];

        for ($label = 1; $label <= $maxLevel; $label++) {
            $relations[$label] = (@$relations[$label - 1] ? $relations[$label - 1] . '.allReferrals' : 'allReferrals');
        }

        $user = auth()->user()->load($relations);
        return view('Template::user.referral.index', compact('pageTitle', 'user', 'maxLevel'));
    }

    public function referralLog()
    {

        if (!gs()->referral_system) {
            $notify[] = ['error', 'Sorry, the referral system is currently unavailable'];
            return back()->withNotify($notify);
        }

        $pageTitle = "Referral Bonus Logs";
        $logs      = ReferralLog::where('referee_id', auth()->id())->with('referee')->orderBy('id', 'desc')->paginate(getPaginate());

        return view('Template::user.referral.logs', compact('pageTitle', 'logs'));
    }

    public function wallets()
    {
        $pageTitle        = "User Wallets";
        $userCoinBalances = UserCoinBalance::where('user_id', auth()->id());

        if (request()->coin_code) {
            $userCoinBalances = $userCoinBalances->whereHas('miner', function ($miner) {
                $miner->where('coin_code', request()->coin_code);
            });
        }

        $userCoinBalances = $userCoinBalances->with('miner')->get();
        return view('Template::user.wallets', compact('pageTitle', 'userCoinBalances'));
    }

    public function walletUpdate(Request $request, $id)
    {
        $userCoinBalance = UserCoinBalance::where('user_id', auth()->id())->findOrFail($id);

        $request->validate([
            "wallet" => 'required|string',
        ]);

        $userCoinBalance->wallet = $request->wallet;
        $userCoinBalance->save();

        $notify[] = ['success', 'Wallet address updated successfully'];
        return back()->withNotify($notify);
    }


    public function addDeviceToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
        ]);

        if ($validator->fails()) {
            return ['success' => false, 'errors' => $validator->errors()->all()];
        }

        $deviceToken = DeviceToken::where('token', $request->token)->first();

        if ($deviceToken) {
            return ['success' => true, 'message' => 'Already exists'];
        }

        $deviceToken          = new DeviceToken();
        $deviceToken->user_id = auth()->user()->id;
        $deviceToken->token   = $request->token;
        $deviceToken->is_app  = Status::NO;
        $deviceToken->save();

        return ['success' => true, 'message' => 'Token saved successfully'];
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
}
