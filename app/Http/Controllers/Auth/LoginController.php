<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');  // ログインしていないユーザーのみがアクセス可能
    }

    /**
     * ログインフォームを表示する
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * ユーザーのログイン処理を実行する
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // 1. リクエストのデータを検証する
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);


        // 2. 管理者ユーザーとしての認証を試みる
        if (Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            // 認証成功: 管理者ページにリダイレクト
            return redirect()->intended(route('admin.index'));
        }

        // 3. 認証を試みる
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            // 認証に成功したら、セッションを再生成する
            $request->session()->regenerate();

            // ダッシュボードにリダイレクトする
            return redirect()->intended('dashboard');
        }

        // 認証に失敗した場合は、ログインページにリダイレクトする
        return back()->withErrors([
            'email' => 'ログイン情報が正しくありません。',
        ])->onlyInput('email');
    }
}
