<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\User;
use Auth;

class LikesController extends Controller
{
  public function __construct(){
    $this->middleware('auth');
  }

  public function likes_index_store(Request $request)
  {
    Like::create(
      array(
        'user_id' => Auth::id(),
        'image_id' => $request->image_id
      )
    );

    return redirect()->route('image_show');
  }

  public function likes_index_destroy(Request $request)
  {
    $user_id = Auth::id();
    Like::where('user_id', $user_id)->where('image_id', $request->image_id)->delete();

    return redirect()->route('image_show');
  }
}
