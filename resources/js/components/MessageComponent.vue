<template>

  <div>

    <div class="my-4 m-screen" id="screen">
      <ol style="list-style: none;">
        <li v-for="message in messages" class="my-4 py-4 border">
          {{ message.message }}
        </li>
      </ol>
    </div>

    <div class="form m-4 border">
        <input type="text" placeholder="text" v-model="s_message" autofocus>
        <button type="submit" name="button" v-on:click="sendMessage">送信</button>
    </div>

  </div>

</template>

<script>
export default {
    name: "MessageComponent",
    props:["messages"],
    data () {
        return {
          s_message: ""
        }
    },
    updated() {
      this.scrollToEnd()
    },
    methods: {
      window:onload = function() {
        var obj = document.getElementById('screen');
        obj.scrollTop = obj.scrollHeight;
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
              alert("インターネット接続を確認してください。");
            });
        axios.get('message_update').then(function(response){
                // 成功したとき
                self.messages = response.data;
            }).catch(function(error){
              alert(error);
            });
      },
      scrollToEnd() {
        var obj = document.getElementById('screen');
        obj.scrollTop = obj.scrollHeight;
      }
    }
}
</script>
