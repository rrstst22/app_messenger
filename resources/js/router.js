import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

import show from "./components/RoomComponent.vue";

const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/",
            name: "show",
            component: show
        }
    ]
});

export default router;
