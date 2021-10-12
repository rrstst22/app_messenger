<template>

  <div class="row">

    <div class="col-md-8">
        <TestComponent v-bind:room_id="room_id" ref="child"></TestComponent>
    </div>
    
    <div class="col-md-4">
      <h1 class="my-4">ルーム</h1>
      <div class="m-screen">
        <div class="mx-2 my-4">
          <ol style="list-style: none; padding-left: 0;">
            <li class="input-group border my-2" v-for="(room, index) in rooms">
              <button type="button" class="form-control rounded btn btn-secondary btn-lg" name="button" v-on:click="selectedRoom(index)">
                {{ room.room_name }}
              </button>
              <button class="btn btn-outline-primary" v-on:click="deleteContact(index)">
                削除
              </button>
            </li>
          </ol>
        </div>
      </div>
    </div>

  </div>

</template>

<script>
import TestComponent from './TestComponent.vue'
export default {
    name: "RoomComponent",
    props:["rooms"],
    data () {
        return {
          s_contact : {email : 'test2@test2', name : 'test2', note : '111'},
          room_id : 0
        }
    },
    components: {
      TestComponent
    },
    created: function () {
      this.screenUpdate();
    },
    methods: {
      screenUpdate: function () {
        var self = this;
        axios.get('room_show').then(function(response){
                // 成功したとき
                self.rooms = response.data;
            }).catch(function(error){
                alert(error);
            });
      },
      updateContact: function () {

        axios.post('contact_update', {
          email: this.s_contact.email,
          name: this.s_contact.name,
          note: this.s_contact.note
        })
            .then(function(response){
                // 成功したとき
            }).catch(function(error){
                alert(error);
            });
        this.screenUpdate();
      },
      selectedRoom: function (index) {
        this.room_id = this.rooms[index].id
        this.$refs.child.screenUpdate(this.rooms[index].id);
      },
      deleteContact: function(index){
        this.s_contact.id = this.contacts[index].id;
        axios.delete('contact_remove', {data: {id: this.s_contact.id}})
            .then(function(response){
            }).catch(function(error){
              alert(error);
            });
        this.screenUpdate();
      }
    }
}
</script>
