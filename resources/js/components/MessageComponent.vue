<template>

  <div>
    <h1 class="my-4">メッセージ</h1>
    <div>ルーム名：{{ room.room_name }}</div>
    <div>メンバー：<span v-for="(user, index) in users" v-bind:key="index">あなた と {{ user.name }}さん </span></div>

    <!-- メッセージ画面 -->
    <div class="my-4 m-screen" id="screen">
      <ol class="no-list">
        <li v-for="(message, index) in messages" v-bind:key="index" class="m-4">

          <!-- 送信者によってメッセージの色を分ける -->
          <div v-if="message.sender_id === login_user_id" class="text-right">
            <button type="button" v-on:click="writeToClipboard(message.message)" class="btn btn-primary btn-lg text-left message-box">
              <div class="m-1">
                {{ message.message }}
              </div>
              <div class="text-right mx-2 name-tag">
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
              <div class="text-right mx-2 name-tag">
                {{ message.name}}
              </div>
            </button>
          </div>

        </li>
      </ol>
    </div><!-- メッセージ画面 -->

    <!-- 送信フォーム -->
    <div class="input-group m-auto">
      <input type="text" class="form-control rounded" maxlength="50" placeholder="text" v-model="send_message" autofocus>
      <button type="submit" class="btn btn-outline-primary" v-on:click="postMessage">
        送信
      </button>
    </div>

  </div>

</template>

<script>
export default {
    name: "MessageComponent",
    props: {
      room_id: {
        type: Number,
        default: null
      },
      login_user_id: {
        type: Number,
        required: true
      }
    },
    data () {
        return {
          users: "",
          send_message: "",
          room: {room_name: "ルームが選択されていません。"},
          messages: {
            message1: {message:"ようこそ！！"},
            message2: {message:"新しくトークを始める場合は、上の「新しくルームを作成」を押してね。"}
          },
        }
    },
    watch: {
      room_id: function(new_room_id) {
        this.updateScreen();
      },
    },
    updated: function() {
      this.scrollToEnd();
    },
    methods: {
      updateScreen: function () {
        var self = this;
        axios.get('message_get', {params:{room_id: this.room_id}})
            .then(function(response){
              self.messages = response.data;
            }).catch(function(error){
            });
        axios.get('roominfo_get', {params:{room_id: this.room_id}})
            .then(function(response){
              self.room = response.data;
            }).catch(function(error){
            });
        axios.get('user_get', {params:{room_id: this.room_id}})
            .then(function(response){
              self.users = response.data;
            }).catch(function(error){

            });
      },
      postMessage: function () {
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
                  self.updateScreen();
                }).catch(function(error){
                  console.error(error.response.data.errors);
                });
          }else{
            alert("ルームを選択してください。");
          }
        }
      },
      scrollToEnd: function () {
        var obj = document.getElementById('screen');
        obj.scrollTop = obj.scrollHeight;
      },
      writeToClipboard: function (text) {
        navigator.clipboard.writeText(text)
              .then(function(response){
                alert("クリップボードにコピーしました。");
              }).catch(function(error){
                console.error(error);
              });
      }
    }
}
</script>
<style scoped>
.no-list {
  list-style: none;
  padding-left: 0;
}
.name-tag {
  font-size: 0.8rem;
  position: absolute;
  bottom: 0px;
  right: 0px;
}
.message-box {
  height: 100px;
  position: relative;
}
</style>
