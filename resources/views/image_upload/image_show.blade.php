@extends('layouts.app')
@section('content')
<div class="container">
  <div class="row">

    <div class="col-md-9">
      <div class="row">

        @foreach ($images as $image)
        <div class="col-lg-6">
          <div class="card my-4">
            <div>
              <img src="storage/images/{{ $image->img_name }}"  class="card-img-top " alt="test" width="200" height="200">
            </div>
            <div class="my-2">

              @if(empty($likes->where('image_id', $image->id)->first()))
                <form class="" action="{{ route('likes_index_store') }}" method="post" enctype="multipart/form-data">
                  @csrf
                  <input type="hidden" name="image_id" value="{{ $image->id }}" />
                  <button type="submit" class="heart heart-button" id='heart-button'>
                    <!-- <i class="far fa-heart fa-2x"></i> -->1
                  </button>
                </form>
              @else
                <form class="" action="{{ route('likes_index_destroy') }}" method="post" enctype="multipart/form-data">
                  @csrf
                  <input type="hidden" name="image_id" value="{{ $image->id }}" />
                  <button type="submit" class="heart heart-liked-button" id='heart-liked-button'>
                    <!-- <i class="fas fa-heart fa-2x" style="color:red;"></i> -->1
                  </button>
                </form>
              @endif

            </div>
          </div>
        </div>
        @endforeach
      </div>
      <div>
        <a href="{{ route('upload_index') }}">画像をアップロード</a>
      </div>
    </div>

    <div class="col-md-3 border">
    </div>

  </div>
</div>
@endsection
