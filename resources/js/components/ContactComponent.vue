<template>

  <div class="row">

    <div class="col-md-6">
        <TestComponent v-bind:email="s_contact.email" ref="child"></TestComponent>
    </div>

    <div class="col-md-6">
      <h1 class="my-4">電話帳</h1>
      <div class="border rounded">
        <div class="my-4">
          <ol style="list-style: none;">
            <li class="border" v-for="(contact, index) in contacts">
              <button type="button" class="mp-4" v-on:click="selectedEmail(index)">
                {{ contact.name }}
                {{ contact.email }}
                {{ contact.note }}
              </button>
            </li>
          </ol>
        </div>

        <div class="form m-4 border">
            <div>
              <label for="name">名前</label>
              <input type="text" name="name" placeholder="text" v-model="s_contact.name">
            </div>
            <div>
              <label for="email">メールアドレス</label>
              <input type="text" name="email" placeholder="text" v-model="s_contact.email">
            </div>
            <div>
              <label for="note">メモ</label>
              <input type="text" name="note" placeholder="text" v-model="s_contact.note">
            </div>
            <button type="submit" name="button" v-on:click="updateContact">送信</button>
        </div>
      </div>

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
      updateContact: function () {
        var self = this;
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
        axios.get('contact_show').then(function(response){
                // 成功したとき
                self.contacts = response.data;
            }).catch(function(error){
                alert(error);
            });
      },
      selectedEmail: function (index) {
        this.s_contact.email = this.contacts[index].email;
        this.$refs.child.screenUpdate(this.contacts[index].email);
      }
    }
}
</script>
