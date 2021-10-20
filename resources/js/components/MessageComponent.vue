<template>

  <div>
    <div class="message-section">
      <h3 class="py-4"><i class="fas fa-comments m-1"></i>メッセージ</h3>
      <div class="py-2 border-top border-bottom">
        <div><i class="fas fa-home m-1"></i>ルーム名：{{ room.room_name }}</div>
        <div><i class="fas fa-users m-1"></i>メンバー：<span v-for="(user, index) in users" v-bind:key="index">あなた と {{ user.name }}さん </span></div>
      </div>
      <!-- メッセージ画面 -->
      <div class="my-2 post-box" id="screen">
        <ol class="no-list">
            <li v-for="(message, index) in messages" v-bind:key="index" class="m-2">

              <transition name="vfade" appear>
              <!-- 送信者によってメッセージの色を分ける -->
              <div v-if="message.sender_id === login_user_id" class="text-right">
                <button type="button" v-on:click="writeToClipboard(message.message)" class="text-left primary-message-box">
                  <div class="p-4">
                    {{ message.message }}
                  </div>
                  <div class="text-right mx-2 name-tag">
                    {{ message.name}}
                  </div>
                </button>
              </div>

              <!-- ログイン者以外のメッセージの場合 -->
              <div v-else>
                <button type="button" v-on:click="writeToClipboard(message.message)" class="secondary-message-box text-left">
                  <div class="p-4">
                    {{ message.message }}
                  </div>
                  <div class="text-right mx-2 name-tag">
                    {{ message.name}}
                  </div>
                </button>
              </div>
            </transition>

            </li>
        </ol>
      </div>

      <!-- 送信フォーム -->
      <form class="my-3" v-on:submit.prevent>
        <div class="input-group m-auto">
          <input type="text" class="form-control rounded" maxlength="50" placeholder="text" v-model="send_message" autofocus>
          <button type="submit" class="btn btn-outline-primary" v-on:click="sendMessage">
            送信
          </button>
        </div>
      </form>
    </div>
  </div>

</template>

<script>
export default {
    name: "MessageComponent",
    props: {
      room_id: {
        type: Number,
        default: ""
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
          updateMessageTimer: "",
          messages: {
            message1: {message:"ようこそ！！"},
            message2: {message:"新しくトークを始める場合は、上の「新しくルームを作成」を押してね。"},
          },
        }
    },
    watch: {
      room_id: function() {
        clearInterval(this.updateMessageTimer); //setInterval重複実行防止
        this.updateMessageTimer = setInterval(this.getMessages, 5000); //メッセージを定期的にアップデート
        this.updateScreen();
      },
    },
    created: function () {
    },
    updated: function() {
      this.scrollToEnd();
    },
    destroyed: function () {
      clearInterval(this.updateMessageTimer);
    },
    methods: {
      updateScreen: function () {
        this.getMessages();
        this.getRoom();
        this.getRoomUsers();
      },
      sendMessage: function () {
        if(this.send_message){
          if(this.room_id){
            var self = this;
            var send_message_tmp = this.send_message; //重複送信防止
            this.send_message = "";
            axios.post('send-message', {
              message: send_message_tmp,
              room_id: self.room_id
            })
                .then(function(response){
                  self.updateScreen();
                }).catch(function(error){
                  alert(error);
                });
          }else{
            alert("ルームを選択してください。");
          }
        }
      },
      getMessages: function () {
        var self = this;
        axios.get('get-messages', {params:{room_id: this.room_id}})
            .then(function(response){
              self.messages = response.data;
            }).catch(function(error){
              alert(error);
            });
      },
      getRoom: function () {
        var self = this;
        axios.get('get-room', {params:{room_id: this.room_id}})
            .then(function(response){
              self.room = response.data;
            }).catch(function(error){
              alert(error);
            });
      },
      getRoomUsers: function () {
        var self = this;
        axios.get('get-room-users', {params:{room_id: this.room_id}})
            .then(function(response){
              self.users = response.data;
            }).catch(function(error){
              alert(error);
            });
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
.message-section {
  padding: 0.5em 1em;
  margin: 2em 0;
  box-shadow: 0 3px 5px rgba(0, 0, 0, 0.22);
  background: #fff;
}
.message-section p {
  margin: 0;
  padding: 0;
}
.primary-message-box {
  position: relative;
  background: #CBFFD3;
  border: none;
  margin: 5px;
  border-radius: 20px;
}
.secondary-message-box {
  position: relative;
  background: #fff;
  border: none;
  margin: 5px;
  border-radius: 20px;
}
.name-tag {
  font-size: 0.8rem;
  position: absolute;
  bottom: 0px;
  right: 0px;
}
.post-box{
    padding: 8px 19px;
    margin: 2em 0;
    background: #F0F8FF;
    height: 350px;
    overflow: scroll;
    overflow-x: hidden;
}
.post-box p {
    margin: 0;
    padding: 0;
}
</style>
