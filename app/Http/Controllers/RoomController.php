<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\User_room;
use Auth;

class RoomController extends Controller
{
  public function create(Request $request)
  {
    $room = Room::create(
      array(
        'room_name' => $request->name
      )
    );
    User_room::create(
      array(
        'user_id' => Auth::id(),
        'room_id' => $room->id
      )
    );
    User_room::create(
      array(
        'user_id' => $request->id,
        'room_id' => $room->id
      )
    );
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
