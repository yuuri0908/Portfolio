<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Mail\VerificationCodeMail;




class PasswordController extends Controller
{

    use AuthorizesRequests, ValidatesRequests;

    // パスワード変更
    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|string|email',
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        //データベースにて同じメールアドレス検索
        $user = User::where('email', $request['email'])->first();

        //パスワードが正しいかどうか判断
        if (!Hash::check($request['current_password'], $user->password)) {
             return response()->json(['message' => 'パスワードが間違っています'], 403);
        }

        //新しいパスワードにアップデート
        $user->update(['password' => Hash::make($request['new_password'])]);

        //レスポンス
        return response()->json(['message' => 'パスワードが変更されました'], 200);

    }




    // //パスワードリセットリクエストの処理
    // public function sendResetLinkEmail(Request $request)
    // {

    //     //$validated = $request->validate(['email' => 'required|email']);

    //     //ユーザー照合
    //     $user = User::where('email', $request->input('email'))->first();

    //     if (!$user) {
    //         return response()->json(['message' => 'ユーザーが見つかりません'], 404);
    //     }


    //     //$reset_token=$user->createToken('reset_token')->plainTextToken;

    //     DB::table('password_resets')->where('email', $user->email)->delete();

    //     DB::table('password_resets')->insert([
    //         'email' => $user['email'],
    //         //'token' => $reset_token,
    //         'created_at' => now()
    // ]);
    //     Mail::to($user->email)->send(new ResetPasswordMail($reset_token));
    //     return response()->json(['message' => 'パスワードリセットリンクが送信されました']);
    // }




    //パスワードの再設定
    public function resetPassword(Request $request)
    {
        //リクエストデータに対してバリデーション実行
        $validated = $request->validate([
            'email' => 'required|string|email',
            'new_password' => 'required|string|min:8|confirmed',
            'new_password_confirmation' => 'required|string|min:8',
        ]);

        //ユーザー照合
        $user = User::where('email', $request['email'])->firstOrFail();

        if (!$user) {
            return response()->json(['message' => 'ユーザーが見つかりません'], 404);
        }


        //パスワードを更新
        $user->update(['password' => $request['new_password']]);

        //変更前のパスワード消去
        DB::table('password_resets')->where(['email' => $request['password']])->delete();

        //レスポンス
        return response()->json(['message' => 'パスワードがリセットされました']);
    }

}

