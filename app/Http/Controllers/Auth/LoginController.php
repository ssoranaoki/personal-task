<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // ログイン処理

    public function login(Request $request)
    {
        // 入力データを取得
        $data = $request->only(['email', 'password']);

        // バリデーションを実行
        $validator = $this->validator($data);

        // バリデーションエラーがある場合
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }


        // バリデーションが成功した場合はログイン処理を行う
        if (Auth::attempt($data)) {
            // ログイン成功の処理を追加
            return redirect()->intended('/home')->with('LoginMessage', 'ログインしました');
        }

        // ログインが失敗した場合はエラーメッセージを表示してリダイレクトさせる
        return redirect()->back()
            ->withInput($request->except('password'))
            ->withErrors(['email' => 'ログインに失敗しました']);
    }



    /**
     * Get a validator for an incoming login request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'email', 'max:191',],
            'password' => ['required', 'min:8',],
        ], [
            'email.required' => 'メールアドレスは必須項目です。',
            'email.email' => '正しいメールアドレスの形式で入力してください。',
            'email.max' => 'メールアドレスは191文字以内で入力してください。',
            'password.required' => 'パスワードは必須項目です。',
            'password.min' => 'パスワードは8文字以上で入力してください。',
        ]);
    }
}
