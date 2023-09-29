<template>
  <header class="bg-dark py-3">
    <div class="main">
      <router-link to="/">
        <h3 class="text-white">Tuna</h3>
      </router-link>
      <div>
        <button class="btn btn-sm btn-outline-light" v-if="isLogin" disabled>
          Welcome Admin
        </button>
        <router-link to="/" class="btn btn-outline-light" v-else="isLogin">
          Login
        </router-link>
      </div>
    </div>
  </header>
</template>

<script setup>
import jsCookie from "js-cookie";
import { inject } from "vue";
import { getInfo } from "../api/auth.js";

const { isLogin, setUserState } = inject("store");
const token = jsCookie.get("token");
if (token) {
  getInfo(token)
    .then(({ data }) => {
      setUserState(data.user);
    })
    .catch((err) => console.log(err));
} else {
  setUserState(null);
}
</script>

<style scoped>
header > div {
  display: flex;
  justify-content: space-between;
}
</style>
