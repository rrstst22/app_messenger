<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Message;
use App\Models\Room;
use App\Models\User_room;
use Auth;

class MessageController extends Controller
{
  public function __construct(){
    $this->middleware('auth');
  }

  public function show()
  {
    return view('message/message');
  }

  public function update(Request $request)
  {
    if(!is_null($request->room_id)){
      $user_id = Auth::id();

      $messages = \DB::table('messages')
      ->join('users','messages.sender_id','=','users.id')
      ->where('room_id', $request->room_id)->get();
    }else {
      $messages = array();
    }
    return $messages;
  }

  public function send(Request $request)
  {
    Message::create(
      array(
        'sender_id' => Auth::id(),
        'room_id' => $request->room_id,
        'message' => $request->message,
        'sent_at' => Carbon::now()
      )
    );
  }

  public function get(Request $request)
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
