<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\VerificationCodeMail;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;


class AuthController extends Controller
{

    use AuthorizesRequests, ValidatesRequests;

    //認証コードを生成し、ユーザーのメールアドレスに送信
    public function sendVerificationCode(Request $request)
    {
        //メールアドレス取得
        $email = $request->input('email');

        //メールアドレスが入力されていないときの処理
        if (empty($email)) {
            return response()->json(['message' => 'メールアドレスが入力されていません'], 422);
        }

        //DBにてメールアドレスが存在するかどうか確認。なかったらnullを返す。
        $user = User::where('email', $email)->first();


        // メールアドレスがnullでないかを確認
        if ($user) {
            // すでに会員登録されている場合の処理
            return response()->json(['message' => 'このメールアドレスは既に登録されています'], 400);
        }

        //認証コード作成
        $verificationCode = Str::random(6);

        // 新しいユーザーオブジェクトを作成して保存
        $user = new User();
        $user->email = $email;
        $user->verification_code = $verificationCode;
        $user->save();

        //登録フォームを定義
        $registerUrl = url('/register?email=' . urlencode($email) . '&code=' . $verificationCode);

        // メールで認証コードを送信
        Mail::to($user->email)->send(new VerificationCodeMail($verificationCode,$registerUrl));

        //レスポンス
        return response()->json(['message' => '認証コードが送信されました'],200);
    }




    // ユーザー情報の登録を行うメソッド
    public function register(Request $request)
    {

        // //リクエストデータに対するバリデーションを実行
        // $validated = $request->validate([
        //     'kanji_last_name' => ['required' , 'regex:/^[一-龥]+$/u' ],//漢字
        //     'kanji_first_name' => ['required' ,'regex:/^[一-龥]+$/u'],//漢字
        //     'hiragana_last_name' => ['required' ,'regex:/^[ぁ-んー]+$/u'],//ひらがな
        //     'hiragana_first_name' => ['required' ,'regex:/^[ぁ-んー]+$/u'],//ひらがな
        //     'roman_last_name' => ['required','regex:/^[a-zA-Z]+$/'], // ローマ字
        //     'roman_first_name' => ['required' ,'regex:/^[a-zA-Z]+$/'], // ローマ字
        //     'email' => 'required|string|email|max:255|unique:users',
        //     'password' => 'required|string|min:8|confirmed',
        // ]);

        // Log::info($request);
        /*$validated['kanji_last_name']*/

        //ユーザーのアップデート
        DB::table('users')
            ->where('email', $request->input('email'))
            ->update([
                'kanji_last_name' => $request->input('kanji_last_name'),
                'kanji_first_name' => $request->input('kanji_first_name'),
                'hiragana_last_name' => $request->input('hiragana_last_name'),
                'hiragana_first_name' => $request->input('hiragana_first_name'),
                'roman_last_name' => $request->input('roman_last_name'),
                'roman_first_name' => $request->input('roman_first_name'),
                'password' => Hash::make($request->input('password')), //パスワードをハッシュ化
                'phone' => $request->input('phone'),
            ]);


        // ユーザーを取得
        $user = User::where('email', $request->input('email'))->first();


        if ($user) {//ユーザー認証されている時
            // token の作成
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json(['access_token' => $token, 'token_type' => 'Bearer'], 201);
        } else {//認証されていない時
            return response()->json(['message' => 'メールアドレスが認証されていません'], 401);

        }
    }


    //ログインメソッド
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ]);
        //データベースな内のユーザー情報と照合
        if (!Auth::attempt($validated)) {
            return response()->json(['message' => '無効なログイン情報です'], 401);
        }
        //認証されたユーザーを取得
        $user = Auth::user();
        //トークン生成
        $token = $user->createToken('auth_token')->plainTextToken;
        //レスポンス
        return response()->json(['access_token' => $token, 'token_type' => 'Bearer'],200);
    }



    // 会員情報API
    public function userInfo(Request $request)
    {
        //認証されたユーザーを取得
        $user = Auth::user();

        //レスポンス
        return response()->json($user);

    }

}

