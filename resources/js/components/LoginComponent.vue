<template>

  <div>
    <!-- モーダルウィンドウ -->
    <div class="overlay" v-show="show_content">

      <transition name="vbounce">
        <div class="content" v-show="show_content">
          <h4 class="my-4"><i class="fas fa-users m-1"></i>ログインユーザーの選択</h4>
          <button class="btn btn-light" v-on:click="closeModal"><i class="fas fa-times m-1"></i>閉じる</button>

          <!-- ユーザー一覧 -->
          <div class="mx-2 my-4 user-list border-top">
            <ol class="no-list">
              <li class="input-group border-bottom" v-for="(user, index) in users" v-bind:key="index">
                <button type="button" class="form-control rounded btn btn-light" v-on:click="guestLogin(index); closeModal()">
                  <i class="fas fa-user m-1"></i>
                  {{ user.name }}
                </button>
              </li>
            </ol>
          </div>

          <!-- ユーザー登録フォーム -->
          <form v-on:submit.prevent>
            <label for="name"><i class="fas fa-user-plus m-1"></i>ユーザー登録</label>
            <div class="input-group m-auto">
              <input class="form-control" type="text" name="name" v-model="new_user_name" v-bind:class={red:error_name} maxlength="10">
              <button type="submit" class="btn btn-success" name="button" v-on:click="createUser">登録</button>
            </div>
          </form>

        </div>
      </transition>

    </div>

  </div>

</template>

<script>
export default {
  name: "LoginComponent",
  props: {
    //親要素でのボタンクリックを検知
    show_login_screen: {
      type: Boolean,
      required: true,
    },
  },
  data () {
      return {
        show_content: false,
        users: "",
        new_user_name: "",
        error_name: false //nameの空欄検知用
      }
  },
  watch: {
    show_login_screen: function() {
      this.openModal(); //ユーザー変更ボタン押下で実行
    },
  },
  created: function() {
    this.updateScreen();
  },
  methods: {
    openModal: function() {
      this.show_content = true;
    },
    closeModal: function() {
      this.show_content = false;
      this.error_name = false;
    },
    //ユーザー一覧を取得
    updateScreen: function() {
      var self = this;
      axios.get('get-other-users')
        .then(function(response) {
            self.users = response.data;
        }).catch(function(error) {
            alert(error);
      });
    },
    //ログインユーザーの取得
    guestLogin: function(index) {
      var self = this;
      axios.post('guest-login', {
          id : this.users[index].id
        }).then(function(response) {
          self.$router.go({path: "/"}); // ユーザー切り替えの為再読込
        }).catch(function(error) {
          alert(error);
      });
    },
    //ユーザー作成
    createUser: function() {
      var self = this;
      //null処理
      if(this.new_user_name) {
        axios.post('create-user', {
            name: self.new_user_name,
          }).then(function(response) {
            alert("登録しました。");
            self.updateScreen();
          }).catch(function(error) {
            alert(error);
        });
      }else {
        this.error_name = true;
      }
    }
  }
}
</script>
<style scoped>
.user-list {
  height: 300px;
  overflow: scroll;
  overflow-x: hidden;
}
</style>
