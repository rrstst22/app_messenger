@extends('layouts.app')
@section('content')
<div class="container">
  <form class="" action="{{ route('room.create') }}" method="post">
    @csrf
    <input type="text" name="id" value=1>
    <input type="text" name="name" value="riu">
    <button type="submit" name="button">送信</button>
  </form>

  <!-- <contact-component v-bind:contacts='{{$contacts}}'></contact-component> -->
  <room-component></room-component>
</div>
@endsection
