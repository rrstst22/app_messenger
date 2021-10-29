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
Auth::routes();

Route::get('/', [App\Http\Controllers\MessageController::class, 'show'])->name('show.message');


// Vue用 同一オリジンAPI
Route::get('auto-login', [App\Http\Controllers\UserController::class, 'autoLogin']);

Route::post('guest-login', [App\Http\Controllers\LoginController::class, 'guestLogin']);
Route::post('create-user', [App\Http\Controllers\LoginController::class, 'createUser']);

Route::get('get-messages', [App\Http\Controllers\MessageController::class, 'getMessages']);
Route::post('send-message', [App\Http\Controllers\MessageController::class, 'sendMessage']);

Route::get('get-room', [App\Http\Controllers\RoomController::class, 'getRoom']);
Route::get('get-login-rooms', [App\Http\Controllers\RoomController::class, 'getLoginRooms']);
Route::post('create-room', [App\Http\Controllers\RoomController::class, 'createRoom']);
Route::delete('remove-room', [App\Http\Controllers\RoomController::class, 'removeRoom']);

Route::get('get-other-users', [App\Http\Controllers\UserController::class, 'getOtherUsers']);
Route::get('get-room-users', [App\Http\Controllers\UserController::class, 'getRoomUsers']);
Route::get('get-login-user-id', [App\Http\Controllers\UserController::class, 'getLoginUserId']);

