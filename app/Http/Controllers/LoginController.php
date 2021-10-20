<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

  public function guestLogin(Request $request)
  {
    Auth::loginUsingId($request->id);
  }

  public function createUser(Request $request){
    $request->validate([
      'name' => 'required|string|max:10|unique:users'
    ],
    [
      'name.required' => 'ユーザ名は必須です。',
      'name.sting'  => '文字列を入力してください。',
      'name.max'  => '最大max文字です。',
      'name.unique' => '別のユーザー名を入力してください。',
    ]);

    $length = 8;
    $email = base_convert(mt_rand(pow(36, $length - 1), pow(36, $length) - 1), 10, 36);
    $password = base_convert(mt_rand(pow(36, $length - 1), pow(36, $length) - 1), 10, 36);

    User::create([
        'name' => $request->name,
        'email' => $email,
        'password' => Hash::make($password),
    ]);
  }
}
