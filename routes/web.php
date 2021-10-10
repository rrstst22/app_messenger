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

Route::get('/', function () {
    return view('index');
});

Route::get('sample', function () {
    return view('basic_vue/sample');
})->name('vue.sample');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('upload_index', [App\Http\Controllers\ImageController::class, 'upload_index'])->name('upload_index');
Route::post('upload_image', [App\Http\Controllers\ImageController::class, 'upload_image'])->name('upload_image');
Route::get('image_show', [App\Http\Controllers\ImageController::class, 'image_show'])->name('image_show');

Route::get('csv_index', [App\Http\Controllers\CsvController::class, 'csv_index'])->name('csv_index'); //表示
Route::post('csv_index', [App\Http\Controllers\CsvController::class, 'upload_regist'])->name('csv_input'); //登録

Route::post('likes_index_store', [App\Http\Controllers\LikesController::class, 'likes_index_store'])->name('likes_index_store');
Route::post('likes_index_destroy', [App\Http\Controllers\LikesController::class, 'likes_index_destroy'])->name('likes_index_destroy');

Route::get('message_show', [App\Http\Controllers\MessageController::class, 'show'])->name('message.show');
Route::post('message_send', [App\Http\Controllers\MessageController::class, 'send'])->name('message.send');
Route::get('message_update', [App\Http\Controllers\MessageController::class, 'update'])->name('message.upate');
