<template>
<div>

  <div v-bind:class="{overlay:show_room}" v-show="showRoomContent">
    <div v-bind:class="{content:show_room}" class="box3">
      <h3 class="my-4">ルーム</h3>

      <div class="m-screen">
        <div class="mx-2">
          <ol class="no-list">
            <li class="input-group border my-2" v-for="(room, index) in rooms" v-bind:key="index">
              <button type="button" class="form-control rounded btn btn-secondary btn-lg" name="button" v-on:click="emitRoomId(index); closeModal()">
                {{ room.room_name }}
              </button>
              <button class="btn btn-outline-primary" v-on:click="deleteRoom(index)">
                削除
              </button>
            </li>
          </ol>
        </div>
      </div>

      <button type="button" v-on:click="closeModal" v-show="show_room">閉じる</button>
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
        default: null
      },
      on_room_screen: {
        type: Boolean,
        required: true,
      },
    },
    data () {
        return {
          rooms : null,
          show_room: false,
          showRoomContent: true,
        }
    },
    watch: {
      room_id: function(new_room_id) {
        this.updateScreen();
      },
      on_room_screen: function(new_openModal) {
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
        this.showRoomContent = true;
        this.updateScreen();
      },
      closeModal: function(){
        if(this.show_room){
          this.showRoomContent = false;
        }
      },
      updateScreen: function () {
        var self = this;
        axios.get('room_show').then(function(response){
                self.rooms = response.data;
            }).catch(function(error){
                alert(error);
            });
      },
      emitRoomId: function (index) {
        this.$emit('screen-update', this.rooms[index].id);
      },
      deleteRoom: function(index){
        var self = this;
        axios.delete('room_remove', {data: {id: this.rooms[index].id}})
            .then(function(response){
              self.$emit('screen-update', null);
              self.updateScreen(); //ルーム一覧アップデート
            }).catch(function(error){
              alert(error);
            });
      },
      handleResize: function() {
        if (window.innerWidth <= 800) {
            this.show_room = true;
            this.showRoomContent = false;
            this.$emit('width-change', this.show_room);
        } else {
            this.show_room = false;
            this.showRoomContent = true;
            this.$emit('width-change', false);
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
.box2{
    padding: 8px 19px;
    margin: 2em 0;
    color: #2c2c2f;
    background: #fff;
    border-top: solid 5px black;
    border-bottom: solid 5px black;
}
.box2 p {
    margin: 0;
    padding: 0;
}
.box3{
    padding: 0.5em 1em;
    margin: 2em 0;
    color: #5d627b;
    background: white;
    border-top: solid 5px #5d627b;
    box-shadow: 0 3px 5px rgba(0, 0, 0, 0.22);
}
.box3 p {
    margin: 0;
    padding: 0;
}
</style>
