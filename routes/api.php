<?php

use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\ConfirmablePasswordController;
use Laravel\Fortify\Http\Controllers\ConfirmedPasswordStatusController;
use Laravel\Fortify\Http\Controllers\EmailVerificationNotificationController;
use Laravel\Fortify\Http\Controllers\EmailVerificationPromptController;
use Laravel\Fortify\Http\Controllers\NewPasswordController;
use Laravel\Fortify\Http\Controllers\PasswordController;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;
use Laravel\Fortify\Http\Controllers\ProfileInformationController;
use Laravel\Fortify\Http\Controllers\RecoveryCodeController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController;
use Laravel\Fortify\Http\Controllers\TwoFactorQrCodeController;
use Laravel\Fortify\Http\Controllers\VerifyEmailController;

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

Route::group(['prefix' => '{lang}'], function () {
    $enableViews = config('fortify.views', true);
    $limiter = config('fortify.limiters.login');
    $twoFactorLimiter = config('fortify.limiters.two-factor');
//    Route::group(['middleware' => 'throttle:2,1'], function () {});

//    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
//        ->middleware(array_filter([
//            $limiter ? 'throttle:'.$limiter : null,
//        ]));
//
//    Route::post('/two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'store'])
//        ->middleware(array_filter([
//            $twoFactorLimiter ? 'throttle:'.$twoFactorLimiter : null,
//        ]));
//
//    if (Features::enabled(Features::registration())) {
//        Route::post('/register', [RegisteredUserController::class, 'store']);
//    }

    Route::post('user/check/field', [UserController::class, 'checkFieldExists'])->name('api.user.check.field');

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('user/logged', [UserController::class, 'getUserLogged'])->name('api.user.logged');
        Route::post('user/profile/edit/{user}', [UserController::class, 'update'])->name('api.user.profile.edit');
//        Route::apiResource('user', UserController::class);

//        $enableViews = config('fortify.views', true);
//        $limiter = config('fortify.limiters.login');
//        $twoFactorLimiter = config('fortify.limiters.two-factor');
//        // Password Reset...
//        if (Features::enabled(Features::resetPasswords())) {
//            if ($enableViews) {
//                Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
//                    ->middleware(['guest:'.config('fortify.guard')])
//                    ->name('password.request');
//
//                Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
//                    ->middleware(['guest:'.config('fortify.guard')])
//                    ->name('password.reset');
//            }
//
//            Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
//                ->middleware(['guest:'.config('fortify.guard')])
//                ->name('password.email');
//
//            Route::post('/reset-password', [NewPasswordController::class, 'store'])
//                ->middleware(['guest:'.config('fortify.guard')])
//                ->name('password.update');
//        }
//        // Registration...
//        if (Features::enabled(Features::registration())) {
//            if ($enableViews) {
//                Route::get('/register', [RegisteredUserController::class, 'create'])
//                    ->middleware(['guest:'.config('fortify.guard')])
//                    ->name('register');
//            }
//
//            Route::post('/register', [RegisteredUserController::class, 'store'])
//                ->middleware(['guest:'.config('fortify.guard')]);
//        }
//
//        // Email Verification...
//        if (Features::enabled(Features::emailVerification())) {
//            if ($enableViews) {
//                Route::get('/email/verify', [EmailVerificationPromptController::class, '__invoke'])
//                    ->middleware(['auth'])
//                    ->name('verification.notice');
//            }
//
//            Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
//                ->middleware(['auth', 'signed', 'throttle:6,1'])
//                ->name('verification.verify');
//
//            Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
//                ->middleware(['auth', 'throttle:6,1'])
//                ->name('verification.send');
//        }
//
//        // Profile Information...
//        if (Features::enabled(Features::updateProfileInformation())) {
//            Route::put('/user/profile-information', [ProfileInformationController::class, 'update'])
//                ->middleware(['auth'])
//                ->name('user-profile-information.update');
//        }
//
//        // Passwords...
//        if (Features::enabled(Features::updatePasswords())) {
//            Route::put('/user/password', [PasswordController::class, 'update'])
//                ->middleware(['auth'])
//                ->name('user-password.update');
//        }
//
//        // Password Confirmation...
//        if ($enableViews) {
//            Route::get('/user/confirm-password', [ConfirmablePasswordController::class, 'show'])
//                ->middleware(['auth'])
//                ->name('password.confirm');
//        }
//
    });
});

