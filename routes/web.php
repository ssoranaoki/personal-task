<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();
// ホム画面
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// 商品一覧画面
Route::get('/home/item', [App\Http\Controllers\ItemController::class, 'index'])->name('list');
// 商品一覧画面 検索機能
Route::get('/home/search', [App\Http\Controllers\ItemController::class, 'search'])->name('search');
// 商品詳細画面
Route::get('/home/detail/{id}', [App\Http\Controllers\ItemController::class, 'detail'])->name('detail');


Route::prefix('items')->group(function () {
    // 管理者画面
    Route::get('/master', [App\Http\Controllers\ItemController::class, 'master'])->name('master');
    // 商品登録画面
    Route::get('/add', [App\Http\Controllers\ItemController::class, 'add'])->name('create');
    // 商品登録機能
    Route::post('/add', [App\Http\Controllers\ItemController::class, 'add'])->name('register');
    // 商品編集画面
    Route::get('/edit/{id}', [App\Http\Controllers\ItemController::class, 'edit'])->name('edit');
    // 商品編集機能
    Route::post('/update/{id}', [App\Http\Controllers\ItemController::class, 'update'])->name('update');
    // 商品削除機能
    Route::get('/delete/{id}', [App\Http\Controllers\ItemController::class, 'delete'])->name('delete');
});
