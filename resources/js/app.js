/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

import Vue from 'vue'
import router from './router'

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('like-component', require('./components/LikeComponent.vue').default);
Vue.component('liked-component', require('./components/LikedComponent.vue').default);
Vue.component('message-component', require('./components/MessageComponent.vue').default);
Vue.component('room-component', require('./components/RoomComponent.vue').default);
Vue.component('room-create-component', require('./components/RoomCreateComponent.vue').default);
Vue.component('login-component', require('./components/LoginComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router: router,
    data () {
        return {
          room_id : null,
          login_user_id : null,
        }
    },
    created: function () {
      this.getLoginUserId();
    },
    methods: {
      screenUpdate: function (room_id) {
        if(room_id){
          this.room_id = room_id;
        }
      },
      getLoginUserId: function () {
        var self = this;
        axios.get('userid_get')
        .then(function(response){
          self.login_user_id = response.data;
        }).catch(function(error){
        });
      },
    }
});
