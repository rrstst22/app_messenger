<template>

  <div>
    <button v-on:click="openModal">ログインユーザ選択</button>

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
      </div>
    </div>

  </div>

</template>

<script>
export default {
    name: "LoginComponent",
    data () {
        return {
          showContent: false,
          users: "",
        }
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
    }
}
</script>
<style scoped>
.no-list {
  list-style: none;
  padding-left: 0;
}
</style>
