@extends('layouts.app')
@section('content')
<div class="container">
  <div class="row">
    <form class="" action="{{ route('contact.update') }}" method="post">
      @csrf
      <input type="text" placeholder="text" name="email">
      <input type="text" placeholder="text" name="name">
      <input type="text" placeholder="text" name="note">
      <button type="submit" name="button" v-on:click="updateContact">送信</button>
    </form>

    <contact-component v-bind:contacts='{{$contacts}}'></contact-component>
    <message-component v-bind:messages='{{$messages}}'></messsage-component>
  </div>
</div>
@endsection
