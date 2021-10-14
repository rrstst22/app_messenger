<template>

  <div>
    <button v-on:click="openRoomModal">新しくルームを作成</button>

    <div id="overlay1" v-show="showRoomContent">
      <div id="content1">
        <h2 class="my-4">ルーム名を入力してください。</h2>
        <button v-on:click="closeModal">閉じる</button>
        <button v-on:click="nextModal">次へ</button>
        <div>
          <input type="text" name="room_name" v-model="room_name" placeholder="ルーム名">
        </div>
      </div>
    </div>

    <div id="overlay2" v-show="showUserContent">
      <div id="content2">
        <h2 class="my-4">ユーザーを選択してください。</h2>
        <button v-on:click="closeModal">Close</button>
        <div class="mx-2 my-4">
          <ol style="list-style: none; padding-left: 0;">
            <li class="input-group border my-2" v-for="(user, index) in users" v-bind:key="index">
              <button type="button" class="form-control rounded btn btn-secondary btn-lg" v-on:click="selectedUser(index)">
                {{ user.name }}
              </button>
            </li>
          </ol>
        </div>
      </div>
    </div>
  </div>

</template>

<script>
export default {
    name: "UserComponent",
    data () {
        return {
          showRoomContent: false,
          showUserContent: false,
          users: "",
          room_id: "",
          room_name: ""
        }
    },
    methods: {
      openRoomModal: function(){
        this.showRoomContent = true;
      },
      nextModal: function(){
        this.screenUpdate();
        this.showRoomContent = false;
        this.showUserContent = true;
      },
      closeModal: function(){
        this.showRoomContent = false;
        this.showUserContent = false;
      },
      screenUpdate: function () {
        var self = this;
        axios.get('user_show').then(function(response){
                self.users = response.data;
            }).catch(function(error){
                alert(error);
            });
      },
      selectedUser: function (index) {
        if(this.room_name){
          axios.post('room_create', {
            id : this.users[index].id,
            name : this.room_name
          })
              .then(function(response){
              }).catch(function(error){
              });
          // console.error(this.users[index].id);
          this.closeModal();
          this.$emit('update');
        }else{
          alert("ルーム名が空欄です。");
        }
      },
    }
}
</script>
