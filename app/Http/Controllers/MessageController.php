<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Message;
use App\Models\Contact;
use Auth;

class MessageController extends Controller
{
  public function __construct(){
    $this->middleware('auth');
  }

  public function show()
  {
    $user_id = Auth::id();
    $messages = Message::where('sender_id', $user_id)->get();
    $contacts = Contact::where('user_id', $user_id)->get();

    return view('message/message', compact('messages', 'contacts'));
  }

  public function update()
  {
    $user_id = Auth::id();
    $messages = Message::where('sender_id', $user_id)->get();

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
