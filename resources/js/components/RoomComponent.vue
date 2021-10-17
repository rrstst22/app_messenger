<template>
<div>

  <div v-bind:class="{overlay:on_modal_mode}" v-show="show_room_content">
    <div v-bind:class="{content:on_modal_mode}" class="room-section">
      <h3 class="my-2">ルームの選択</h3>

      <div class="px-2 room-list">
        <ol class="no-list">
          <li class="input-group border my-2" v-for="(room, index) in rooms" v-bind:key="index">
            <button type="button" class="form-control rounded btn btn-secondary" name="button" v-on:click="showMessages(index); closeModal()">
              {{ room.room_name }}
            </button>
            <button class="btn btn-outline-primary" v-on:click="deleteRoom(index)">
              削除
            </button>
          </li>
        </ol>
      </div>

      <button type="button" v-on:click="closeModal" v-show="on_modal_mode">閉じる</button>
    </div>
  </div>

</div>
</template>

<script>
export default {
    name: "RoomComponent",
    props: {
      room_id: {
        type: Number,
        default: ""
      },
      show_room_screen: {
        type: Boolean,
        required: true,
      },
    },
    data () {
        return {
          rooms : "",
          on_modal_mode: false,
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
      window.addEventListener('resize', this.handleResize);
    },
    methods: {
      openModal: function(){
        this.show_room_content = true;
      },
      closeModal: function(){
        //モーダル画面表示ではない場合は、何もしない。
        if(this.on_modal_mode){
          this.show_room_content = false;
        }
      },
      updateScreen: function () {
        var self = this;
        axios.get('get-login-rooms').then(function(response){
                self.rooms = response.data;
            }).catch(function(error){
                alert(error);
            });
      },
      showMessages: function (index) {
        this.$emit('room-click', this.rooms[index].id);
      },
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
      handleResize: function() {
        if (window.innerWidth <= 800) {
            this.on_modal_mode = true;
            this.show_room_content = false;
            this.$emit('screen-type-change', this.on_modal_mode);
        } else {
            this.on_modal_mode = false;
            this.show_room_content = true;
            this.$emit('screen-type-change', false);
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
    border-top: solid 5px #5d627b;
    box-shadow: 0 3px 5px rgba(0, 0, 0, 0.22);
}
.room-section p {
    margin: 0;
    padding: 0;
}
.room-list {
  height: 500px;
  overflow: scroll;
  overflow-x: hidden;
}
</style>
