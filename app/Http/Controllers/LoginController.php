<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{

  // ゲストログイン処理
  public function guestLogin(Request $request)
  {
    // id=1 のゲストユーザー情報がDBに存在すれば、ゲストログインする
    Auth::loginUsingId($request->id);
  }
}
