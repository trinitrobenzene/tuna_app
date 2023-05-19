import { createRouter, createWebHistory } from "vue-router";
import Home from "../pages/home/index.vue";
import signUp from "../pages/home/signup.vue";
import admin from "./admin";

const routes = [
  ...admin,
  {
    path: "/",
    name: "home",
    component: Home,
  },
  {
    path: "/signup",
    name: "signUp",
    component: signUp,
  },
];

export default createRouter({
  history: createWebHistory(),
  routes,
});
