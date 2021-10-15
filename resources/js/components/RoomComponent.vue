<template>
<div>

  <div class="d-flex flex-row">
    <UserComponent ref="child" @update="screenUpdate"></UserComponent>
    <login-component></login-component>
  </div>

  <div class="row">

    <div class="col-md-8">
        <TestComponent v-bind:room_id="room_id" ref="child"></TestComponent>
    </div>

    <div class="col-md-4">
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

  </div>
</div>

</template>

<script>
import TestComponent from './TestComponent.vue';
import UserComponent from './UserComponent.vue';
export default {
    name: "RoomComponent",
    data () {
        return {
          room_id : null,
          rooms : null
        }
    },
    components: {
      TestComponent, UserComponent
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
        this.room_id = this.rooms[index].id; //Props更新
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
