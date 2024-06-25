<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordController;

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



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//認証コードを送信
//api/sendVerificationCode'
Route::post('/sendVerificationCode', [AuthController::class, 'sendVerificationCode'])->name('sendverificationcode');

//ユーザー登録処理
//api/register
Route::post('/register', [AuthController::class, 'register']);

//ログイン処理
//api/login
Route::post('/login', [AuthController::class, 'login']);

//パスワードリセット
    //api/reset-password
    Route::post('/reset-password', [PasswordController::class, 'resetPassword']);


Route::middleware('auth:sanctum')->group(function () {
    //認証されたユーザーのパスワードを変更
    //api/change-password
    Route::put('/change-password', [PasswordController::class, 'changePassword']);
    // //パスワードリセットリクエストの処理
    // //api/reset-password-request
    // Route::post('/reset-password-request', [PasswordController::class, 'sendResetLinkEmail']);
    //認証されたユーザーの情報を取得
    //api/user-info
    Route::get('/userinfo', [AuthController::class, 'userInfo']);
});

