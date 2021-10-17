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

Route::get('message/show-message/{any}', function () {
    return view('message/show-message');
})->where('any', '.*');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('autologin', [App\Http\Controllers\UserController::class, 'autologin'])->name('autologin');

Route::get('upload_index', [App\Http\Controllers\ImageController::class, 'upload_index'])->name('upload_index');
Route::post('upload_image', [App\Http\Controllers\ImageController::class, 'upload_image'])->name('upload_image');
Route::get('image_show', [App\Http\Controllers\ImageController::class, 'image_show'])->name('image_show');

Route::get('csv_index', [App\Http\Controllers\CsvController::class, 'csv_index'])->name('csv_index');
Route::post('csv_index', [App\Http\Controllers\CsvController::class, 'upload_regist'])->name('csv_input');

Route::post('likes_index_store', [App\Http\Controllers\LikesController::class, 'likes_index_store'])->name('likes_index_store');
Route::post('likes_index_destroy', [App\Http\Controllers\LikesController::class, 'likes_index_destroy'])->name('likes_index_destroy');

Route::group(['prefix' => 'message'], function(){
  Route::post('guest-login', [App\Http\Controllers\LoginController::class, 'guestLogin'])->name('guest.login');
  Route::post('create-user', [App\Http\Controllers\LoginController::class, 'createUser'])->name('create.user');

  Route::get('show-message', [App\Http\Controllers\MessageController::class, 'show'])->name('show.message');
  Route::get('get-messages', [App\Http\Controllers\MessageController::class, 'getMessages'])->name('get.messages');
  Route::post('send-message', [App\Http\Controllers\MessageController::class, 'sendMessage'])->name('send.message');

  Route::get('get-room', [App\Http\Controllers\RoomController::class, 'getRoom'])->name('get.room');
  Route::get('get-login-rooms', [App\Http\Controllers\RoomController::class, 'getLoginRooms'])->name('get.login.rooms');
  Route::post('create-room', [App\Http\Controllers\RoomController::class, 'createRoom'])->name('create.room');
  Route::delete('remove-room', [App\Http\Controllers\RoomController::class, 'removeRoom'])->name('remove.room');

  Route::get('get-other-users', [App\Http\Controllers\UserController::class, 'getOtherUsers'])->name('get.other.users');
  Route::get('get-room-users', [App\Http\Controllers\UserController::class, 'getRoomUsers'])->name('get.room.users');
  Route::get('get-login-user-id', [App\Http\Controllers\UserController::class, 'getLoginUserId'])->name('get.login.user.id');
});
