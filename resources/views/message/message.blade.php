@extends('layouts.app')
@section('content')
<div class="container">
  <div class="row">
    <message-component v-bind:messages='{{$messages}}'></messsage-component>
  </div>
</div>
@endsection
