<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Message;
use App\Models\Room;
use App\Models\User_room;
use Auth;

class UserController extends Controller
{

  public function show()
  {
    $id = Auth::id();
    $users = User::where('id', '!=', $id)->get(['id', 'name']);

    return $users;
  }
  public function get_id()
  {
    $id = Auth::id();

    return $id;
  }
  public function autologin()
  {
    Auth::loginUsingId(1);
    return redirect('/');
  }

}
