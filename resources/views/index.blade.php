@extends('layouts.app')
@section('content')
<div id="loading">
  <div class="spinner"></div>
</div>

<div class="container">
  <div>
    <a href="{{ route('show.message') }}">メッセージ</a>
  </div>
</div>
@endsection
