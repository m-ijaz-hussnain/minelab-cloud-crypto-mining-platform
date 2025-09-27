<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('Api')->name('api.')->group(function () {

    Route::controller('AppController')->group(function () {
        Route::get('general-setting', 'generalSetting');
        Route::get('get-countries', 'getCountries');
        Route::get('language/{key}', 'getLanguage');
        Route::get('policies', 'policies');
        Route::get('faq', 'faq');
    });

    Route::namespace('Auth')->group(function () {
        Route::controller('LoginController')->group(function () {
            Route::post('login', 'login');
            Route::post('check-token', 'checkToken');
            Route::post('social-login', 'socialLogin');
        });

        Route::post('register', 'RegisterController@register');

        Route::controller('ForgotPasswordController')->group(function () {
            Route::post('password/email', 'sendResetCodeEmail');
            Route::post('password/verify-code', 'verifyCode');
            Route::post('password/reset', 'reset');
        });
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('user-data-submit', 'UserController@userDataSubmit');

        //authorization
        Route::middleware('registration.complete')->controller('AuthorizationController')->group(function () {
            Route::get('authorization', 'authorization');
            Route::get('resend-verify/{type}', 'sendVerifyCode');
            Route::post('verify-email', 'emailVerification');
            Route::post('verify-mobile', 'mobileVerification');
            Route::post('verify-g2fa', 'g2faVerification');
        });

        Route::middleware(['check.status'])->group(function () {

            Route::middleware('registration.complete')->group(function () {

                Route::controller('UserController')->group(function () {
                    Route::get('dashboard', 'dashboard');

                    Route::post('profile-setting', 'submitProfile');
                    Route::post('change-password', 'submitPassword');

                    Route::get('user-info', 'userInfo');

                    //KYC
                    Route::get('kyc-form', 'kycForm');
                    Route::post('kyc-submit', 'kycSubmit');

                    //wallets
                    Route::get('wallets', 'wallets');
                    Route::post('wallets/update', 'walletUpdate');

                    //referral
                    Route::get('referral', 'referral');
                    Route::get('referral/log', 'referralLog');

                    //Report
                    Route::any('deposit/history', 'depositHistory');
                    Route::get('transactions', 'transactions');

                    Route::post('add-device-token', 'addDeviceToken');
                    Route::get('push-notifications', 'pushNotifications');
                    Route::post('push-notifications/read/{id}', 'pushNotificationsRead');

                    //2FA
                    Route::get('twofactor', 'show2faForm');
                    Route::post('twofactor/enable', 'create2fa');
                    Route::post('twofactor/disable', 'disable2fa');

                    Route::post('delete-account', 'deleteAccount');
                });

                Route::controller('OrderPlanController')->group(function () {
                    Route::get('plans', 'plans');
                    Route::post('plan/purchase', 'orderPlan');
                    Route::get('purchased-plan', 'purchasedPlan')->name('plan.purchased');
                    Route::get('plans/active', 'activePlan');
                    Route::get('mining-track', 'miningTrack');
                });

                Route::controller('BadgeController')->group(function () {
                    Route::get('achievements', 'badge')->name('badge');
                });

                // Withdraw
                Route::controller('WithdrawController')->prefix('withdraw')->group(function () {
                    Route::get('method', 'withdrawMethod')->middleware('kyc');
                    Route::post('request', 'withdrawStore')->middleware('kyc');
                    Route::get('history', 'withdrawLog');
                });

                // Payment
                Route::controller('PaymentController')->group(function () {
                    Route::prefix('deposit')->group(function () {
                        Route::get('methods', 'methods')->name('deposit');
                        Route::post('insert', 'depositInsert')->name('deposit.insert');
                    });
                });

                Route::controller('TicketController')->prefix('ticket')->group(function () {
                    Route::get('/', 'supportTicket');
                    Route::post('create', 'storeSupportTicket');
                    Route::get('view/{ticket}', 'viewTicket');
                    Route::post('reply/{id}', 'replyTicket');
                    Route::post('close/{id}', 'closeTicket');
                    Route::get('download/{attachment_id}', 'ticketDownload');
                });
            });
        });

        Route::get('logout', 'Auth\LoginController@logout');
    });
});
