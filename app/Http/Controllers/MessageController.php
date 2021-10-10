<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Message;
use Auth;

class MessageController extends Controller
{
  public function __construct(){
    $this->middleware('auth');
  }

  public function show()
  {
    $messages = Message::all();

    return view('message/message', compact('messages'));
  }

  public function update()
  {
    $messages = Message::all();

    return $messages;
  }

  public function send(Request $request)
  {
    Message::create(
      array(
        'sender_id' => Auth::id(),
        'receiver_id' => Auth::id(),
        'message' => $request->message,
        'sent_at' => Carbon::now()
      )
    );
    return redirect()->back();
  }
}
