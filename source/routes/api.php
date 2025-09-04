<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ApiKeyMiddleware;
use Kreait\Firebase\Factory;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('register', [\App\Http\Controllers\API\AuthController::class, 'register']);
Route::post('login', [\App\Http\Controllers\API\AuthController::class, 'login']);
Route::post('verify-otp', [\App\Http\Controllers\API\AuthController::class, 'verifyOtp']);
Route::post('resend-otp', [\App\Http\Controllers\API\AuthController::class, 'resendOtp']);

Route::post('app-about-us', [\App\Http\Controllers\API\HomeController::class, 'appAboutUs']);
Route::post('app-privacy', [\App\Http\Controllers\API\HomeController::class, 'appPrivacy']);
Route::post('app-terms', [\App\Http\Controllers\API\HomeController::class, 'appterms']);

Route::post('home', [\App\Http\Controllers\API\HomeController::class, 'simpleHome']);
Route::post('send-notification', [\App\Http\Controllers\API\MatchmakingController::class, 'sendNotification']);
Route::post('start-up', [\App\Http\Controllers\API\HomeController::class, 'startUp']);


Route::middleware('auth:api')->group(function () {

    Route::post('/filter', [\App\Http\Controllers\API\MatchmakingController::class, 'findMatches']);
    Route::post('/find-user-match', [\App\Http\Controllers\API\MatchmakingController::class, 'findUserMatches']);
    Route::post('/update-device-token', [\App\Http\Controllers\API\AuthController::class, 'updateToken']);
    Route::post('/get-setting', [\App\Http\Controllers\API\AuthController::class, 'getSetting']);
    Route::post('/update-setting', [\App\Http\Controllers\API\AuthController::class, 'updateSetting']);
    Route::post('/logout', [\App\Http\Controllers\API\AuthController::class, 'logout']);

    Route::post('/create-room', [\App\Http\Controllers\API\ChatController::class, 'createRoom']);
    Route::post('/chat-history', [\App\Http\Controllers\API\ChatController::class, 'chatHistory']);
    Route::post('/chat-conversions', [\App\Http\Controllers\API\ChatController::class, 'chatConversions']);
    Route::post('temp-upload', [\App\Http\Controllers\API\ChatController::class, 'uploadChatFile']);

    Route::post('get-countries', [\App\Http\Controllers\API\HomeController::class, 'getCountries']);
    Route::post('get-area/{city_id}', [\App\Http\Controllers\API\HomeController::class, 'getArea']);
    Route::post('get-education', [\App\Http\Controllers\API\HomeController::class, 'getEducation']);
    Route::post('get-nationality', [\App\Http\Controllers\API\HomeController::class, 'getNationality']);
    Route::post('get-religion', [\App\Http\Controllers\API\HomeController::class, 'getReligion']);
    Route::post('get-languages', [\App\Http\Controllers\API\HomeController::class, 'getLanguages']);
    Route::post('get-occupations', [\App\Http\Controllers\API\HomeController::class, 'getOccupations']);
    Route::post('get-hobbies', [\App\Http\Controllers\API\HomeController::class, 'getHobbies']);

    Route::post('on_boarding_1', [\App\Http\Controllers\API\AuthController::class, 'onBoarding1']);
    Route::post('on_boarding_23', [\App\Http\Controllers\API\AuthController::class, 'onBoarding23']);
    Route::post('on_boarding_4', [\App\Http\Controllers\API\AuthController::class, 'onBoarding4']);
    Route::post('on_boarding_5', [\App\Http\Controllers\API\AuthController::class, 'onBoarding5']);
    Route::post('on_boarding_6', [\App\Http\Controllers\API\AuthController::class, 'onBoarding6']);
    Route::post('on_boarding_7', [\App\Http\Controllers\API\AuthController::class, 'onBoarding7']);

    Route::post('mm-registration', [\App\Http\Controllers\API\AuthController::class, 'mmRegistration']);
    Route::post('mm-profile', [\App\Http\Controllers\API\AuthController::class, 'mmProfile']);
    Route::post('mm-profile-image', [\App\Http\Controllers\API\AuthController::class, 'mmProfileImage']);
    Route::post('mm-client-toggle-status', [\App\Http\Controllers\API\AuthController::class, 'mmClientToggleStatus']);

    Route::post('/send-match-request', [\App\Http\Controllers\API\MatchmakingController::class, 'sendMatchRequest']);
    Route::post('/match-request-details', [\App\Http\Controllers\API\MatchmakingController::class, 'matchRequestDetails']);
    Route::post('/my-match-requests', [\App\Http\Controllers\API\MatchmakingController::class, 'myMatchRequests']);
    Route::post('/update-match-request-status', [\App\Http\Controllers\API\MatchmakingController::class, 'matchRequestStatus']);

    Route::post('client-profile', [\App\Http\Controllers\API\AuthController::class, 'clientProfile']);
    Route::post('client-images', [\App\Http\Controllers\API\AuthController::class, 'clientImageSave']);
    Route::post('client-image-update', [\App\Http\Controllers\API\AuthController::class, 'storeClientImages']);

    Route::post('client-preferences-save', [\App\Http\Controllers\API\PrefrencesController::class, 'storeClientPreferences']);
    Route::post('client-preferences-remove', [\App\Http\Controllers\API\PrefrencesController::class, 'removeClientPreferences']);

    Route::post('client-paragraph', [\App\Http\Controllers\API\ClientParagraphController::class, 'generate']);

    Route::post('toggle-wishlist', [\App\Http\Controllers\API\HomeController::class, 'toggleWishlist']);
    Route::post('my-wishlist', [\App\Http\Controllers\API\HomeController::class, 'myWishlist']);

    Route::post('payment-methods', [\App\Http\Controllers\API\PaymentController::class, 'paymentMethods']);
    Route::post('payment-plans', [\App\Http\Controllers\API\PaymentController::class, 'paymentPlans']);
    Route::post('user-create-payment', [\App\Http\Controllers\API\PaymentController::class, 'userCreatePayment']);
    Route::post('my-payment-history', [\App\Http\Controllers\API\PaymentController::class, 'myPaymentHistory']);
    Route::post('my-wallet', [\App\Http\Controllers\API\PaymentController::class, 'myWallet']);
//    admin panel api here is for testing
    Route::post('admin-action-on-payment', [\App\Http\Controllers\API\PaymentController::class, 'adminActionOnPayment']);


});
