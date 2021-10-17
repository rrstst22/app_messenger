<template>

  <div class="message-section">
    <h3 class="my-3">メッセージ</h3>
    <div class="room-info-box">
      <div>ルーム名：{{ room.room_name }}</div>
      <div>メンバー：<span v-for="(user, index) in users" v-bind:key="index">あなた と {{ user.name }}さん </span></div>
    </div>
    <!-- メッセージ画面 -->
    <div class="my-2 post-box" id="screen">
      <ol class="no-list">
        <li v-for="(message, index) in messages" v-bind:key="index" class="m-2">

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

        </li>
      </ol>
    </div><!-- メッセージ画面 -->

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
          messages: {
            message1: {message:"ようこそ！！"},
            message2: {message:"新しくトークを始める場合は、上の「新しくルームを作成」を押してね。"}
          },
        }
    },
    watch: {
      room_id: function() {
        this.updateScreen();
      },
    },
    updated: function() {
      this.scrollToEnd();
    },
    methods: {
      updateScreen: function () {
        var self = this;
        axios.get('get-messages', {params:{room_id: this.room_id}})
            .then(function(response){
              self.messages = response.data;
            }).catch(function(error){
              alert(error);
            });
        axios.get('get-room', {params:{room_id: this.room_id}})
            .then(function(response){
              self.room = response.data;
            }).catch(function(error){
              alert(error);
            });
        axios.get('get-room-users', {params:{room_id: this.room_id}})
            .then(function(response){
              self.users = response.data;
            }).catch(function(error){
              alert(error);
            });
      },
      sendMessage: function () {
        if(this.send_message){
          if(this.room_id){
            var self = this;
            var send_message_tmp = this.send_message; //重複送信回避
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
.room-info-box {
  padding: 0.5em 1em;
  margin: 2px 0;
  color: #232323;
  background: #fff8e8;
  border-left: solid 10px #ffc06e;
}
.room-info-box p {
  margin: 0;
  padding: 0;
}
.primary-message-box {
  position: relative;
  background: #CBFFD3;
  border: none;
  box-shadow: 0 3px 5px rgba(0, 0, 0, 0.22);
  margin: 5px;
  border-radius: 20px;
}
.secondary-message-box {
  position: relative;
  background: #fff;
  border: none;
  box-shadow: 0 3px 5px rgba(0, 0, 0, 0.22);
  padding: 5px;
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
    color: #2c2c2f;
    background: #F8F8FF;
    height: 350px;
    overflow: scroll;
    overflow-x: hidden;
}
.post-box p {
    margin: 0;
    padding: 0;
}
</style>
