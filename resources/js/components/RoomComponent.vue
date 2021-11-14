<template>

  <div>
    <!-- classの抜差しで、通常モードとモーダルモードの切り替え -->
    <div v-bind:class="{overlay:on_modal_mode}" v-show="show_room_content">
      <transition name="vbounce">
        <div class="room-section" v-bind:class="{content:on_modal_mode}" v-show="show_room_content">
          <h3 class="py-4"><i class="fas fa-home m-1"></i>ルーム選択</h3>

          <!-- 閉じるボタン（モーダルモード中のみ） -->
          <div class="text-center border-top border-bottom">
            <button type="button" class="btn btn-light" v-on:click="closeModal" v-show="on_modal_mode"><i class="fas fa-times m-1"></i>閉じる</button>
          </div>

          <!-- ルーム一覧の表示 -->
          <div class="mx-2 my-4 room-list border-top">
            <ol class="no-list">
              <li class="input-group border-bottom" v-for="(room, index) in rooms" v-bind:key="index">

                <transition name="vfade" appear>
                  <button type="button" class="form-control rounded btn btn-light" name="button" v-on:click="showMessages(index); closeModal()">
                    <i class="fas fa-users m-1"></i>
                    {{ room.room_name }}
                  </button>
                </transition>

                <transition name="vfade" appear>
                  <button class="btn btn-outline-primary" v-on:click="deleteRoom(index)">
                    削除
                  </button>
                </transition>

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
    name: "RoomComponent",
    props: {
      //新しいルームの追加を検知
      room_id: {
        type: Number,
        default: ""
      },
      //親要素でのボタンクリックを検知
      show_room_screen: {
        type: Boolean,
        required: true,
      },
    },
    data () {
        return {
          rooms : "",
          on_modal_mode: false, //モーダルモードのオンオフ
          show_room_content: true,
        }
    },
    watch: {
      room_id: function() {
        this.updateScreen();
      },
      show_room_screen: function() {
        this.openModal();
      },
    },
    created: function () {
      this.updateScreen();
      this.handleResize();
    },
    mounted() {
      window.addEventListener('resize', this.handleResize); //リサイズ検知
    },
    methods: {
      openModal: function(){
        this.show_room_content = true;
      },
      closeModal: function(){
        if(this.on_modal_mode){   //モーダル画面表示ではない場合は、画面を閉じない。
          this.show_room_content = false;
        }
      },
      //ルーム情報を取得
      updateScreen: function () {
        var self = this;
        axios.get('get-login-rooms').then(function(response){
                self.rooms = response.data;
            }).catch(function(error){
                alert(error);
            });
      },
      //メッセージコンポーネントへクリックされたルームを伝達
      showMessages: function (index) {
        this.$emit('room-click', this.rooms[index].id);
      },
      //ルームを削除
      deleteRoom: function(index){
        var self = this;
        axios.delete('remove-room', {data: {id: this.rooms[index].id}})
            .then(function(response){
              self.$emit('room-click', null);
              self.updateScreen();
            }).catch(function(error){
              alert(error);
            });
      },
      //画面幅によってモーダルモードと通常モードの変更
      handleResize: function() {
        if (window.innerWidth <= 770) {
            this.on_modal_mode = true;
            this.show_room_content = false;
            this.$emit('screen-type-change', this.on_modal_mode); //ルーム変更ボタンの有無を調整
        } else {
            this.on_modal_mode = false;
            this.show_room_content = true;
            this.$emit('screen-type-change', false); //ルーム変更ボタンの有無を調整
        }
      },
    }
}
</script>
<style scoped>
.room-section{
    padding: 0.5em 1em;
    margin: 2em 0;
    color: #5d627b;
    background: white;
    box-shadow: 0 3px 5px rgba(0, 0, 0, 0.22);
}
.room-section p {
    margin: 0;
    padding: 0;
}
.room-list {
  height: 300px;
  overflow: scroll;
  overflow-x: hidden;
}
</style>
