<template>

  <div>
    <h1 class="my-4">メッセージ</h1>
    <div class="my-4 m-screen" id="screen">
      <ol style="list-style: none; padding-left: 0;">
        <li v-for="message in messages" class="m-4">
          <button type="button" class="btn btn-primary btn-lg btn-block" style="height:100px; position:relative;">
            <div class="m-1" style="">
              {{ message.message }}
            </div>
            <div class="text-right mx-2" style="font-size:0.8rem; position:absolute; bottom:0px; right:0px;">{{ message.name}}</div>
          </button>
        </li>
      </ol>
    </div>

    <div class="input-group m-auto">
      <input type="text" class="form-control rounded" placeholder="text" v-model="s_message" autofocus>
      <button type="submit" class="btn btn-outline-primary" v-on:click="sendMessage">送信</button>
    </div>
  </div>

</template>

<script>
export default {
    name: "TestComponent",
    props:["room_id", "messages", "error"],
    data () {
        return {
          s_message: ""
        }
    },
    created: function () {
    },
    updated() {
      this.scrollToEnd();
    },
    methods: {
      window:onload = function() {
        var obj = document.getElementById('screen');
        obj.scrollTop = obj.scrollHeight;
      },
      screenUpdate: function (room_id) {
        var self = this;
        axios.post('message_update', {room_id: room_id})
            .then(function(response){
                self.messages = response.data;
                if(!self.messages.length){
                  alert("メッセージがありません。");
                }
            }).catch(function(error){
              console.log(error.reponse.data);
              console.log(error.reponse.status);
              console.log(error.reponse.header);
              alert(error);
            });
      },
      sendMessage: function () {
        var self = this;
        var obj = document.getElementById('screen');
        var s_message_tmp = self.s_message;
        self.s_message = "";
        axios.post('message_send', {
          message: s_message_tmp,
          room_id: this.room_id
        })
            .then(function(response){
                // 成功したとき
            }).catch(function(error){
              alert(error);
            });
        this.screenUpdate(this.room_id);
      },
      scrollToEnd() {
        var obj = document.getElementById('screen');
        obj.scrollTop = obj.scrollHeight;
      }
    }
}
</script>
