<template>
<div>

      <h1 class="my-4">ルーム</h1>
      <div class="m-screen">
        <div class="mx-2 my-4">
          <ol style="list-style: none; padding-left: 0;">
            <li class="input-group border my-2" v-for="(room, index) in rooms" v-bind:key="index">
              <button type="button" class="form-control rounded btn btn-secondary btn-lg" name="button" v-on:click="selectedRoom(index)">
                {{ room.room_name }}
              </button>
              <button class="btn btn-outline-primary" v-on:click="deleteRoom(index)">
                削除
              </button>
            </li>
          </ol>
        </div>
      </div>

</div>

</template>

<script>
export default {
    name: "RoomComponent",
    props:["room_id"],
    data () {
        return {
          rooms : null
        }
    },
    watch: {
      room_id: function(new_room_id) {
        this.room_id = new_room_id;
        this.screenUpdate();
      }
    },
    created: function () {
      this.screenUpdate();
    },
    methods: {
      screenUpdate: function () {
        var self = this;
        axios.get('room_show').then(function(response){
                self.rooms = response.data;
            }).catch(function(error){
                alert(error);
            });
      },
      selectedRoom: function (index) {
        this.$emit('screen-update', this.rooms[index].id);
      },
      deleteRoom: function(index){
        var self = this;
        axios.delete('room_remove', {data: {id: this.rooms[index].id}})
            .then(function(response){
              self.room_id = null; //Props更新
              self.screenUpdate(); //ルーム一覧アップデート
            }).catch(function(error){
              alert(error);
            });
      }
    }
}
</script>
