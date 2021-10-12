@extends('layouts.app')
@section('content')
<div class="container">
  <form class="" action="{{ route('message.send') }}" method="post">
    @csrf
    <input type="text" name="room_id" value=3>
    <input type="text" name="message" value="aa">
    <button type="submit" name="button">送信</button>
  </form>

  <!-- <contact-component v-bind:contacts='{{$contacts}}'></contact-component> -->

  <room-component></room-component>
</div>
@endsection
