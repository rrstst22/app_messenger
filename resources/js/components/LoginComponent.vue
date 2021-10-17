<template>

  <div>

    <div id="overlay1" v-show="showContent">
      <div id="content1">
        <h2 class="my-4">ユーザーを選択してください。</h2>
        <button v-on:click="closeModal">Close</button>
        <div class="mx-2 my-4">
          <ol class="no-list">
            <li class="input-group border my-2" v-for="(user, index) in users" v-bind:key="index">
              <button type="button" class="form-control rounded btn btn-secondary btn-lg" v-on:click="postUserId(index)">
                {{ user.name }}
              </button>
            </li>
          </ol>
        </div>
        <label for="name">ユーザー登録</label>
        <input type="text" name="name" v-model="new_user_name" maxlength="10">
        <button type="submit" name="button" v-on:click="createUser">登録</button>
      </div>
    </div>

  </div>

</template>

<script>
export default {
    name: "LoginComponent",
    props: {
      on_login_screen: {
        type: Boolean,
        required: true,
      },
    },
    data () {
        return {
          showContent: false,
          users: "",
          new_user_name: ""
        }
    },
    watch: {
      on_login_screen: function(new_openModal) {
        this.openModal();
      },
    },
    methods: {
      openModal: function(){
        this.showContent = true;
        this.updateScreen();
      },
      closeModal: function(){
        this.showContent = false;
      },
      updateScreen: function () {
        var self = this;
        axios.get('user_show').then(function(response){
                self.users = response.data;
            }).catch(function(error){
                alert(error);
            });
      },
      postUserId: function (index) {
        var self = this;
        axios.post('guest', {
          id : this.users[index].id
        })
            .then(function(response){
              self.$router.go({path: self.$router.currentRoute.path});
            }).catch(function(error){
            });
        this.closeModal();
      },
      createUser: function () {
        var self = this;
        axios.post('user_create', {
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
</script>
<style scoped>
.no-list {
  list-style: none;
  padding-left: 0;
}
</style>
