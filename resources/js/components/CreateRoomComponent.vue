<template>

  <div>

    <div class="overlay" v-show="show_room_content">
      <div class="content">
        <h3 class="my-4">ルーム名の入力</h3>
        <div class="m-2">
          <button class="btn btn-secondary" v-on:click="closeModal">閉じる</button>
          <button class="btn btn-primary" v-on:click="nextModal">次へ</button>
        </div>
        <div class="mx-2 my-4">
          <input type="text" name="room_name" v-model="room_name" maxlength="12" placeholder="ルーム名">
          <small class="form-text text-muted">※12文字以内</small>
        </div>
      </div>
    </div>

    <div class="overlay" v-show="show_user_content">
      <div class="content">
        <h3 class="my-4">トーク相手の選択</h3>
        <div class="m-2">
          <button class="btn btn-secondary" v-on:click="backModal">戻る</button>
          <button class="btn btn-danger" v-on:click="closeModal">閉じる</button>
        </div>
        <div class="mx-2 my-4 px-2 user-list">
          <ol class="no-list">
            <li class="input-group border my-2" v-for="(user, index) in users" v-bind:key="index">
              <button type="button" class="form-control rounded btn btn-secondary" v-on:click="createRoom(index)">
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
    name: "CreateRoomComponent",
    data () {
        return {
          show_room_content: false,
          show_user_content: false,
          users: "",
          room_name: ""
        }
    },
    props: {
      show_room_creater: {
        type: Boolean,
        required: true,
      },
    },
    watch: {
      show_room_creater: function(new_show_room_creater) {
        this.openRoomModal();
      },
    },
    created: function () {
      this.updateScreen();
    },
    methods: {
      openRoomModal: function(){
        this.show_room_content = true;
      },
      nextModal: function(){
        this.show_room_content = false;
        this.show_user_content = true;
      },
      backModal: function(){
        this.show_room_content = true;
        this.show_user_content = false;
      },
      closeModal: function(){
        this.show_room_content = false;
        this.show_user_content = false;
      },
      updateScreen: function () {
        var self = this;
        axios.get('get-other-users').then(function(response){
                self.users = response.data;
            }).catch(function(error){
                alert(error);
            });
      },
      createRoom: function (index) {
        var self = this;
        if(this.room_name){
          axios.post('create-room', {
            id : this.users[index].id,
            name : this.room_name
          })
              .then(function(response){
                self.$emit('roominfo-input', response.data);
                self.room_name = "";
              }).catch(function(error){
                alert(error.response.data.errors);
              });
          this.closeModal();
        }else{
          alert("ルーム名が空欄です。");
          this.backModal();
        }
      },
    }
}
</script>
<style scoped>
.user-list {
  height: 350px;
  overflow: scroll;
  overflow-x: hidden;
}
</style>
