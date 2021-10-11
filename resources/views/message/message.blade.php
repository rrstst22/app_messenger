@extends('layouts.app')
@section('content')
<div class="container">
  <contact-component v-bind:contacts='{{$contacts}}'></contact-component>
</div>
@endsection
