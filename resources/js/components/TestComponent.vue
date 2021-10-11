<template>

  <div>
    <h1 class="my-4">メッセージ</h1>
    <div class="my-4 m-screen" id="screen">
      <ol style="list-style: none;">
        <li v-for="message in messages" class="m-4 py-4 border">
          {{ message.message }}
        </li>
      </ol>
    </div>

    <div class="form m-4 border">
        <input type="text" placeholder="text" v-model="s_message" autofocus>
        <button type="submit" name="button" v-on:click="sendMessage">送信</button>
    </div>
    {{email}}

  </div>

</template>

<script>
export default {
    name: "TestComponent",
    props:["email", "messages"],
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
      screenUpdate: function (email) {
        var self = this;
        axios.post('message_update', {email: email})
            .then(function(response){
                self.messages = response.data;
            }).catch(function(error){
              alert("履歴がありません");
            });
      },
      sendMessage: function () {
        var self = this;
        var obj = document.getElementById('screen');
        var s_message_tmp = self.s_message;
        self.s_message = "";
        axios.post('message_send', {message: s_message_tmp})
            .then(function(response){
                // 成功したとき
            }).catch(function(error){
            });
      },
      scrollToEnd() {
        var obj = document.getElementById('screen');
        obj.scrollTop = obj.scrollHeight;
      }
    }
}
</script>
