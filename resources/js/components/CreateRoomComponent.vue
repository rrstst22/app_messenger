<template>

  <div>
    <!-- 親コンポーネントのボタンクリックを検知し表示 -->
    <div class="overlay" v-show="show_overlay">
      <transition name="vslide">
        <!-- １画面目 -->
        <div class="content" v-show="show_room_content">
          <h3 class="my-4"><i class="fas fa-home m-1"></i>ルーム名の入力</h3>
          <form v-on:submit.prevent>
            <div class="text-center border-top border-bottom">
              <button type="button" class="btn btn-light" v-on:click="closeModal"><i class="fas fa-times m-1"></i>閉じる</button>
              <button type="submit" class="btn btn-light" v-on:click="nextModal"><i class="fas fa-arrow-circle-right m-1"></i>次へ</button>
            </div>
            <div class="mx-2 my-4">
              <input class="form-control" type="text" name="room_name" v-model="room_name" maxlength="12" placeholder="ルーム名">
              <small class="form-text text-muted">※12文字以内</small>
            </div>
          </form>
        </div>
      </transition>

      <transition name="vbounce2">
        <!-- ２画面目 -->
        <div class="content" v-show="show_user_content">
          <h3 class="my-4"><i class="fas fa-user m-1"></i>トーク相手の選択</h3>
          <div class="m-2 text-center border-top border-bottom">
            <button class="btn btn-light" v-on:click="backModal"><i class="fas fa-arrow-circle-left m-1"></i>戻る</button>
            <button class="btn btn-light" v-on:click="closeModal"><i class="fas fa-times m-1"></i>閉じる</button>
          </div>
          <div class="mx-2 my-4 user-list border-top">
            <ol class="no-list">
              <li class="input-group border-bottom" v-for="(user, index) in users" v-bind:key="index">
                <button type="button" class="form-control rounded btn btn-light" v-on:click="createRoom(index)">
                  <i class="fas fa-user m-1"></i>
                  {{ user.name }}
                </button>
              </li>
            </ol>
          </div>
        </div>
      </transition>
    </div>
  </div>

</template>

<script>
export default {
    name: "CreateRoomComponent",
    data () {
        return {
          show_overlay: false,
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
      show_room_creater: function() {
        this.openRoomModal();
      },
    },
    methods: {
      openRoomModal: function(){
        this.updateScreen();
        this.show_overlay = true;
        this.show_room_content = true;
      },
      nextModal: function(){
        this.show_room_content = false;
        this.show_user_content = true;
      },
      backModal: function(){
        this.show_user_content = false;
        this.show_room_content = true;
      },
      closeModal: function(){
        this.show_overlay = false;
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
        if(this.room_name){ //ルーム名の空欄チェック
          axios.post('create-room', {
            id : this.users[index].id,
            name : this.room_name
          })
              .then(function(response){
                self.$emit('roominfo-input', response.data); //ルームコンポーネントへ変更を伝える
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
  height: 300px;
  overflow: scroll;
  overflow-x: hidden;
}
</style>
