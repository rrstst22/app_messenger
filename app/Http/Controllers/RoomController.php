<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\User_room;
use Auth;

class RoomController extends Controller
{
  public function update(Request $request)
  {
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

    $rooms = \DB::table('user_rooms')
    ->join('rooms','user_rooms.room_id','=','rooms.id')
    ->where('user_id', $user_id)->get();

    return $rooms;
  }

  public function remove(Request $request)
  {
    Room::findOrFail($request->id)->delete();
  }
}
