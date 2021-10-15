@extends('layouts.app')
@section('content')
<div class="container">
  <div>
    <a href="{{ route('image_show') }}">画像管理</a>
  </div>
  <div>
    <a href="{{ route('csv_index') }}">CSV入力</a>
  </div>
  <div>
    <a href="{{ route('message.show') }}">メッセージ</a>
  </div>
</div>
@endsection
