<template>
  <VHeader />
  <div class="main">
    <router-view />
  </div>
</template>

<script>
import { provide, ref, readonly } from "vue";
import VHeader from "./components/VHeader.vue";
import { computed } from "@vue/reactivity";

export default {
  components: {
    VHeader: VHeader,
  },
  setup() {
    const isLogin = ref(false);
    const user = ref(null);
    const setUserState = (payload) => {
      isLogin.value = payload ? true : false;
      user.value = payload ?? null;
    };

    // create provider
    provide("store", {
      isLogin: computed(() => isLogin).value,
      user: computed(() => user).value,
      setUserState,
    });
  },
};
</script>

<style>
.main {
  width: 84%;
  margin: auto;
}
</style>
