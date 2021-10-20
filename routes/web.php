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
    //return view('index');
    return redirect()->route('show.message');
});

Auth::routes();

Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('autologin', [App\Http\Controllers\UserController::class, 'autologin'])->name('autologin');

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
