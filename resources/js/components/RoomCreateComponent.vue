<template>

  <div>

    <div id="overlay1" v-show="showRoomContent">
      <div id="content1">
        <h2 class="my-4">ルーム名を入力してください。</h2>
        <div class="m-2">
          <button v-on:click="closeModal">閉じる</button>
          <button v-on:click="nextModal">次へ</button>
        </div>
        <div class="mx-2 my-4">
          <input type="text" name="room_name" v-model="room_name" maxlength="12" placeholder="ルーム名">
          <small class="form-text text-muted">※12文字以内</small>
        </div>
      </div>
    </div>

    <div id="overlay2" v-show="showUserContent">
      <div id="content2">
        <h2 class="my-4">ユーザーを選択してください。</h2>
        <div class="m-2">
          <button v-on:click="backModal">戻る</button>
          <button v-on:click="closeModal">閉じる</button>
        </div>
        <div class="mx-2 my-4">
          <ol class="no-list">
            <li class="input-group border my-2" v-for="(user, index) in users" v-bind:key="index">
              <button type="button" class="form-control rounded btn btn-secondary btn-lg" v-on:click="postUserId(index)">
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
    name: "RoomCreateComponent",
    data () {
        return {
          showRoomContent: false,
          showUserContent: false,
          users: "",
          room_name: ""
        }
    },
    props: {
      on_room_creater: {
        type: Boolean,
        required: true,
      },
    },
    watch: {
      on_room_creater: function(new_on_room_creater) {
        this.openRoomModal();
      },
    },
    methods: {
      openRoomModal: function(){
        this.updateScreen();
        this.showRoomContent = true;
      },
      nextModal: function(){
        this.showRoomContent = false;
        this.showUserContent = true;
      },
      backModal: function(){
        this.showRoomContent = true;
        this.showUserContent = false;
      },
      closeModal: function(){
        this.showRoomContent = false;
        this.showUserContent = false;
      },
      updateScreen: function () {
        var self = this;
        axios.get('user_show').then(function(response){
                self.users = response.data;
            }).catch(function(error){
                alert(error);
            });
      },
      postUserId: function (index) {
        var self = this;
        if(this.room_name){
          axios.post('room_create', {
            id : this.users[index].id,
            name : this.room_name
          })
              .then(function(response){
                self.$emit('screen-update', response.data);
                self.room_name = null;
              }).catch(function(error){
                console.error(error.response.data.errors);
              });
          this.closeModal();
        }else{
          alert("ルーム名が空欄です。");
        }
      },
    }
}
</script>
<style scoped>
.no-list {
  list-style: none;
  padding-left: 0;
}
</style>
