<template>

  <div class="row">
    <button v-on:click="openModal">新しくルームを作成</button>

    <div id="overlay" v-show="showContent">
      <div id="content">
        <h2 class="my-4">ユーザーを選択してください。</h2>
        <button v-on:click="closeModal">Close</button>
        <div>
          <div class="mx-2 my-4">
            <ol style="list-style: none; padding-left: 0;">
              <li class="input-group border my-2" v-for="(user, index) in users" v-bind:key="index">
                <button type="button" class="form-control rounded btn btn-secondary btn-lg" v-on:click="selectedUser(index)">
                  {{ user.name }}
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
export default {
    name: "UserComponent",
    data () {
        return {
          showContent: false,
          users: ""
        }
    },
    methods: {
      openModal: function(){
        this.showContent = true;
        this.screenUpdate();
      },
      closeModal: function(){
        this.showContent = false;
      },
      screenUpdate: function () {
        var self = this;
        axios.get('user_show').then(function(response){
                // 成功したとき
                self.users = response.data;
            }).catch(function(error){
                alert(error);
            });
      },
      selectedUser: function (index) {
        axios.post('room_create', {
          id : this.users[index].id,
          name : this.users[index].name
        })
            .then(function(response){
            }).catch(function(error){
                alert(error);
            });
        this.closeModal();
        this.$emit('update');
      },
    }
}
</script>
