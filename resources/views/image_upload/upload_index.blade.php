@extends('layouts.app')
@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-9">
      <h1>画像アップロード</h1>
      <form action="{{ route('upload_image') }}" method="POST" class="form" enctype="multipart/form-data">
        @csrf
        <div class="form-group my-3">
          <label for="img_path">画像ファイル</label><br>
          <input type="file" name="img_path" accept="image/png, image/jpeg" /><br>
          @if ($errors->has('img_path'))
              <span class="invalid-feedback" role="alert">
              {{ $errors->first('img_path') }}
              </span>
          @endif
        </div>

        <div class="center-block form-actions">
          <button type="submit" class="submit-button btn btn-primary btn-lg">
            追加
          </button>
        </div>
      </form>

      @if ($errors->any())
        <div class="alert alert-danger my-4">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
    </div>

    <div class="col-md-3">
    </div>
  </div>
</div>
@endsection
