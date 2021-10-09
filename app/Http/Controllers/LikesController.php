<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Image;
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

    Image::findOrFail($request->image_id)->increment('likes_count');

    return redirect()->route('image_show');
  }

  public function likes_index_destroy(Request $request)
  {
    $user_id = Auth::id();
    Like::where('user_id', $user_id)->where('image_id', $request->image_id)->delete();
    Image::findOrFail($request->image_id)->decrement('likes_count');

    return redirect()->route('image_show');
  }
}
