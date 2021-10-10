<template>

  <div>

    <div class="my-4 m-screen" id="screen">
      <ol style="list-style: none;">
        <li v-for="message in messages" class="my-4 py-4 border">
          {{ message.message }}
        </li>
      </ol>
    </div>

    <div class="form my-4">
        <input type="text" placeholder="text" v-model="s_message">
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
        axios.post('message_send', {message: this.s_message})
            .then(function(response){
                // 成功したとき
                self.s_message = "";
            }).catch(function(error){
                // 失敗したとき（成功ルートでもエラーが発生すればerror）
                alert(error);
            });
        axios.get('message_update').then(function(response){
                // 成功したとき
                self.messages = response.data;
            }).catch(function(error){
                // 失敗したとき（成功ルートでもエラーが発生すればerror）
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
