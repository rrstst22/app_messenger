<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\Like;
use App\Models\User;
use Auth;

class ImageController extends Controller
{
  public function __construct(){
    $this->middleware('auth');
  }

  public function upload_index()
  {
    return view('image_upload/upload_index');
  }

  public function image_show()
  {
    $images = Image::orderBy('id', 'desc')->get();
    $user_id = Auth::id();
    $likes = Like::where('user_id', $user_id)->get();

    return view('image_upload/image_show', compact('images', 'likes'));
  }

  public function upload_image(Request $request)
  {
    $request->validate([
			'img_path' => 'required|max:1024|file|image|mimes:png,jpeg'
		],
    [
      'img_path.required' => '画像ファイルは必須です。',
      'img_path.mimes'  => 'pngまたはjpegのみです。',
    ]);

		$upload_image = $request->file('img_path'); //ファイル情報取得

		if($upload_image) {
      $img_name = $upload_image->getClientOriginalName(); //元のファイル名の取得
      $filename = pathinfo($img_name, PATHINFO_FILENAME);    //ファイル名のみを取得
      $extension = $upload_image->getClientOriginalExtension();    //拡張子を取得
      $filenameToStore = $filename."_".time().".".$extension;
      $path = $upload_image->storeAs('public/images', $filenameToStore); //保存して、パスを取得

			//画像の保存に成功したらDBに記録する
			if($path){
				Image::create([
					"img_name" => $filenameToStore,
					"img_path" => $path
				]);
			}
		}
		return redirect()->route('image_show');
  }
}
