<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Contact;
use Auth;

class ContactController extends Controller
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
    $user_id = Auth::id();
    $contacts = Contact::where('user_id', $user_id)->get();

    return $contacts;
  }

  public function remove(Request $request)
  {
    Contact::findOrFail($request->id)->delete();
  }
}
