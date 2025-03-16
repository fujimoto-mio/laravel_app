<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;

Route::get('/',[TaskController::class,'index']); //一覧表示用のURLとコントローラ場所
Route::post('/create',[TaskController::class,'create']);  //タスク追加用のURLとコントローラ場所
Route::post('/edit',[TaskController::class,'edit']);  //タスク更新用
Route::post('/delete',[TaskController::class,'delete']);  //タスク削除用

Route::resource('tasks', TaskController::class);

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', [LoginController::class, 'showLoginForm'])->middleware('guest')->name('login');

// トップページのルート
Route::get('/', [HomeController::class, 'index'])->name('home');

// ダッシュボードのルート（ログインが必要）
Route::get('/dashboard', [HomeController::class, 'dashboard'])->middleware('auth')->name('dashboard');

// ユーザー登録のルート
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register')->middleware('guest');
Route::post('register', [RegisterController::class, 'register']);

// ログインのルート
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);

// ログアウトのルート
Route::post('logout', [LogoutController::class, 'logout'])->name('logout');

// ダッシュボードのルート（ログインが必要）
Route::get('/dashboard', [HomeController::class, 'dashboard'])->middleware('auth')->name('dashboard');

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register')->middleware('guest');
Route::post('register', [RegisterController::class, 'register']);
