<template>

  <div>
    <h1 class="my-4">メッセージ</h1>
    <div>ルーム名：{{ room.room_name }}</div>
    <div>メンバー：<span v-for="user in users">あなた と {{ user.name }}さん </span></div>

    <!-- メッセージ画面 -->
    <div class="my-4 m-screen" id="screen">
      <ol style="list-style: none; padding-left: 0;">
        <li v-for="message in messages" class="m-4">

          <!-- 送信者によってメッセージの色を分ける -->
          <div v-if="message.sender_id === login_user_id" class="text-right">
            <button type="button" v-on:click="writeToClipboard(message.message)" class="btn btn-primary btn-lg text-left" style="height:100px; position:relative;">
              <div class="m-1">
                {{ message.message }}
              </div>
              <div class="text-right mx-2" style="font-size:0.8rem; position:absolute; bottom:0px; right:0px;">
                {{ message.name}}
              </div>
            </button>
          </div>

          <!-- ログイン者以外のメッセージの場合 -->
          <div v-else>
            <button type="button" v-on:click="writeToClipboard(message.message)" class="btn btn-secondary btn-lg text-left" style="height:100px; position:relative;">
              <div class="m-1">
                {{ message.message }}
              </div>
              <div class="text-right mx-2" style="font-size:0.8rem; position:absolute; bottom:0px; right:0px;">
                {{ message.name}}
              </div>
            </button>
          </div>

        </li>
      </ol>
    </div><!-- メッセージ画面 -->

    <!-- 送信フォーム -->
    <div class="input-group m-auto">
      <input type="text" class="form-control rounded" placeholder="text" v-model="send_message" autofocus>
      <button type="submit" class="btn btn-outline-primary" v-on:click="sendMessage">
        送信
      </button>
    </div>

  </div>

</template>

<script>
export default {
    name: "MessageComponent",
    props:["room_id", "login_user_id"],
    data () {
        return {
          users: "",
          messages: "",
          send_message: "",
          room: {room_name: "ルームが選択されていません。"},
        }
    },
    watch: {
      room_id: function(new_room_id) {
        this.room_id = new_room_id;
        this.screenUpdate();
      },
      login_user_id: function(new_login_user_id) {
        this.login_user_id = new_login_user_id;
      }
    },
    updated() {
      this.scrollToEnd();
    },
    methods: {
      screenUpdate: function () {
        var self = this;
        axios.post('message_update', {room_id: this.room_id})
            .then(function(response){
              self.messages = response.data;
            }).catch(function(error){
            });
        this.getRoomInfo(this.room_id);
        this.getUserInfo(this.room_id);
      },
      sendMessage: function () {
        if(this.send_message){
          if(this.room_id){
            var self = this;
            var send_message_tmp = this.send_message; //重複送信回避
            this.send_message = "";
            axios.post('message_send', {
              message: send_message_tmp,
              room_id: self.room_id
            })
                .then(function(response){
                  self.screenUpdate();
                }).catch(function(error){
                });
          }else{
            alert("ルームを選択してください。");
          }
        }
      },

      getUserInfo: function (room_id) {
        var self = this;
        if(room_id){
          axios.post('user_get', {room_id: room_id})
          .then(function(response){
            self.users = response.data;
          }).catch(function(error){
          });
        }else{
          self.users = null;
        }
      },
      getRoomInfo: function (room_id) {
        var self = this;
        if(room_id){
          axios.post('roominfo_get', {room_id: room_id})
              .then(function(response){
                self.room = response.data;
              }).catch(function(error){
              });
        }else{
          this.room.room_name = "ルームが選択されていません";
        }
      },
      scrollToEnd: function () {
        var obj = document.getElementById('screen');
        obj.scrollTop = obj.scrollHeight;
      },
      writeToClipboard: function (text) {
        navigator.clipboard.writeText(text)
              .then(function(response){
                alert("クリップボードにコピーしました。")
              }).catch(function(e){
                console.error(e);
              });
      }
    }
}
</script>
