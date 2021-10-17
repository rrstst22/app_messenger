@extends('layouts.app')
@section('content')
<div class="container">

  <div>
    <div class="d-flex flex-row">
      <button v-on:click="on_login_screen=!on_login_screen">ログインユーザ選択</button>
      <button v-on:click="on_room_creater=!on_room_creater">新しくルームを作成</button>
      <button v-on:click='on_room_screen=!on_room_screen' v-show="width_change">ルームの表示</button>
    </div>
  </div>

  <div>
    <room-create-component v-bind:on_room_creater="on_room_creater" @screen-update="updateScreen"></room-create-component>
  </div>
  <div>
    <login-component v-bind:on_login_screen="on_login_screen"></login-component>
  </div>


  <div class="row">
    <div class="col-md-8">
      <message-component v-bind:room_id="room_id" v-bind:login_user_id="login_user_id"></message-component>
    </div>
    <div class="col-md-4">
      <room-component v-bind:room_id="room_id" v-bind:on_room_screen="on_room_screen" @screen-update="updateScreen"  @width-change="getShow"></room-component>
    </div>
  </div>

</div>
@endsection
