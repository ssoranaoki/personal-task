<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\HomeController;
use Illuminate\Routing\RouteGroup;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();
// ホーム画面
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('forceHttps');
// 商品一覧画面
Route::get('/home/item', [App\Http\Controllers\HomeController::class, 'list'])->name('list');
// 商品一覧画面 検索機能
Route::get('/home/search', [App\Http\Controllers\HomeController::class, 'search'])->name('search');
// 商品詳細画面
Route::get('/home/detail/{id}', [App\Http\Controllers\HomeController::class, 'detail'])->name('detail');


// 管理者しかアクセスできない
Route::group(['middleware' => 'admin'], function () {
    // 管理者画面
    Route::get('/item/master', [App\Http\Controllers\ItemController::class, 'master'])->name('master');
    // 商品登録画面
    Route::get('/item/ItemCreate', [App\Http\Controllers\ItemController::class, 'ItemCreate'])->name('ItemCreate');
    // 商品登録機能
    Route::post('/item/ItemRegister', [App\Http\Controllers\ItemController::class, 'ItemRegister'])->name('ItemRegister');
    // 商品編集画面
    Route::get('/item/edit/{id}', [App\Http\Controllers\ItemController::class, 'edit'])->name('edit');
    // 商品編集機能
    Route::post('/item/update/{id}', [App\Http\Controllers\ItemController::class, 'update'])->name('update');
    // 商品削除機能
    Route::get('/item/delete/{id}', [App\Http\Controllers\ItemController::class, 'delete'])->name('delete');
});
