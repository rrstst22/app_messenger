<template>

  <div class="row">

    <div class="col-md-8">
        <TestComponent v-bind:email="s_contact.email" ref="child"></TestComponent>
    </div>

    <div class="col-md-4">
      <h1 class="my-4">電話帳</h1>
      <div class="m-screen">
        <div class="mx-2 my-4">
          <ol style="list-style: none; padding-left: 0;">
            <li class="input-group border my-2" v-for="(contact, index) in contacts">
              <button type="button" class="form-control rounded btn btn-secondary btn-lg" name="button" v-on:click="selectedEmail(index)">
                {{ contact.email }}
              </button>
              <button class="btn btn-outline-primary" v-on:click="deleteContact(index)">
                削除
              </button>
            </li>
          </ol>
        </div>

        <div class="form m-4 border">
          <h3 class="m-2">電話帳追加</h3>
          <div class="form-group">
            <label for="name">名前</label>
            <input type="text" class="form-control" name="name" placeholder="text" v-model="s_contact.name">
          </div>
          <div class="form-group">
            <label for="email">メールアドレス</label>
            <input type="text" class="form-control" name="email" placeholder="text" v-model="s_contact.email">
          </div>
          <div class="form-group">
            <label for="note">メモ</label>
            <input type="text" class="form-control" name="note" placeholder="text" v-model="s_contact.note">
          </div>
          <button type="submit" name="button" v-on:click="updateContact">送信</button>
        </div>
      </div>
{{s_contact.id}}
    </div>

  </div>

</template>

<script>
import TestComponent from './TestComponent.vue'
export default {
    name: "ContactComponent",
    props:["contacts"],
    data () {
        return {
          s_contact : {email : 'test2@test2', name : 'test2', note : '111'},
        }
    },
    components: {
      TestComponent
    },
    methods: {
      screenUpdate: function () {
        var self = this;
        axios.get('contact_show').then(function(response){
                // 成功したとき
                self.contacts = response.data;
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
      selectedEmail: function (index) {
        this.s_contact.email = this.contacts[index].email;
        this.$refs.child.screenUpdate(this.contacts[index].email);
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
