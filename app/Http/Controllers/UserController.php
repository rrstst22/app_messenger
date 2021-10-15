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
  public function get_room_users(Request $request)
  {
    $login_user_id = Auth::id();
    $users = \DB::table('user_rooms')
    ->join('users','user_rooms.user_id','=','users.id')
    ->where('room_id', $request->room_id)
    ->where('user_id', '!=', $login_user_id)
    ->get(['name', 'room_id']);

    return $users;
  }

}
