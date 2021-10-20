@extends('layouts.app')
@section('content')
<div id="app">
  <div class="container">

    <!-- 以下のボタンでVueコンポーネントの表示切り替え -->
    <div>
      <div class="d-flex flex-row">
        <button class="btn btn-light" v-on:click="show_login_screen=!show_login_screen">
          <i class="fas fa-users m-1"></i>
          ユーザ変更
        </button>
        <button class="btn btn-light" v-on:click="show_room_creater=!show_room_creater">
          <i class="fas fa-plus m-1"></i>
          ルーム作成
        </button>
        <button class="btn btn-light" v-on:click='show_room_screen=!show_room_screen' v-show="on_modal_mode"><!--ウィンドウ幅でボタン有無の調整-->
          <i class="fas fa-spinner m-1"></i>
          ルーム変更
        </button>
      </div>
    </div>

    <div>
      <create-room-component v-bind:show_room_creater="show_room_creater" v-on:roominfo-input="updateRoomId"></create-room-component>
    </div>
    <div>
      <login-component v-bind:show_login_screen="show_login_screen"></login-component>
    </div>

    <div class="row">
      <div class="col-md-8">
        <message-component v-bind:room_id="room_id" v-bind:login_user_id="login_user_id"></message-component>
      </div>
      <div class="col-md-4">
        <room-component v-bind:room_id="room_id" v-bind:show_room_screen="show_room_screen" v-on:room-click="updateRoomId" v-on:screen-type-change="switchRoomButton"></room-component>
      </div>
    </div>

  </div>
</div>
@endsection
