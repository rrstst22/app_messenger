<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Message;
use App\Models\Contact;
use App\Models\Room;
use App\Models\User_room;
use Auth;

class UserController extends Controller
{
  public function update(Request $request)
  {
    //$receiver_id = User::where('email', $request->email)->first()->id;

    Contact::create(
      array(
        'user_id' => Auth::id(),
        //'receiver_id' => $receiver_id,
        'name' => $request->name,
        'email' => $request->email,
        'note' => $request->note
      )
    );
    return redirect()->back();
  }

  public function show()
  {
    $names = User::get(['id', 'name']);

    return $names;
  }

  public function remove(Request $request)
  {
    Contact::findOrFail($request->id)->delete();
  }
}
