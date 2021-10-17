<template>

  <div>

    <div class="overlay" v-show="show_content">
      <div class="content">
        <h3 class="my-4">ログインユーザーの選択</h3>
        <button class="btn btn-secondary" v-on:click="closeModal">閉じる</button>

        <div class="mx-2 my-4 px-2 user-list">
          <ol class="no-list">
            <li class="input-group border my-2" v-for="(user, index) in users" v-bind:key="index">
              <button type="button" class="form-control rounded btn btn-secondary" v-on:click="guestLogin(index); closeModal()">
                {{ user.name }}
              </button>
            </li>
          </ol>
        </div>

        <label for="name">ユーザー登録</label>
        <input type="text" name="name" v-model="new_user_name" maxlength="10">
        <button type="submit" class="btn btn-success" name="button" v-on:click="createUser">登録</button>
      </div>
    </div>

  </div>

</template>

<script>
export default {
    name: "LoginComponent",
    props: {
      show_login_screen: {
        type: Boolean,
        required: true,
      },
    },
    data () {
        return {
          show_content: false,
          users: "",
          new_user_name: ""
        }
    },
    watch: {
      show_login_screen: function() {
        this.openModal();
      },
    },
    created: function () {
      this.updateScreen();
    },
    methods: {
      openModal: function(){
        this.show_content = true;
      },
      closeModal: function(){
        this.show_content = false;
      },
      updateScreen: function () {
        var self = this;
        axios.get('get-other-users').then(function(response){
                self.users = response.data;
            }).catch(function(error){
                alert(error);
            });
      },
      guestLogin: function (index) {
        var self = this;
        axios.post('guest-login', {
          id : this.users[index].id
        })
            .then(function(response){
              self.$router.go({path: self.$router.currentRoute.path});
            }).catch(function(error){
              alert(error);
            });
      },
      createUser: function () {
        var self = this;
        if(this.new_user_name){
          axios.post('create-user', {
            name: self.new_user_name,
          }).then(function(response){
            alert("登録しました。");
            self.updateScreen();
          }).catch(function(error){
            alert(error.response.data.errors.name);
          });
        }
      }
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
