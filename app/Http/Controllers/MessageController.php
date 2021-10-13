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
    $user_id = Auth::id();
    $users = User::where('id', '!=', $user_id)->get(['id', 'name']);

    return view('message/message', compact('users'));
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
    return redirect()->back();
  }
}
