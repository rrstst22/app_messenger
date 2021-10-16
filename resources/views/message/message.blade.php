@extends('layouts.app')
@section('content')
<div class="container">

<div class="test">
      <button v-show="buttonActive" @click="returnTop" class="px-2 py-2 bg-dark" style="width: 50px; height: 50px;">

      </button>
</div>

  <div>
    <div class="d-flex flex-row">
      <div>
        <room-create-component ref="child" @screen-update="screenUpdate"></room-create-component>
      </div>
      <div>
        <login-component></login-component>
      </div>
    </div>

    <div class="row">

      <div class="col-md-8">
        <message-component v-bind:room_id="room_id" v-bind:login_user_id="login_user_id" ref="child"></message-component>
      </div>

      <div class="col-md-4" v-show="room_screen">
        <room-component v-bind:room_id="room_id" @screen-update="screenUpdate"></room-component>
      </div>

    </div>

  </div>

</div>
@endsection
