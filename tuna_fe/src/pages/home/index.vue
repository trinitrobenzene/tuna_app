<template>
  <div class="m-auto py-5 w-75">
    <div v-if="store.isLogin.value">
      Do you want to logout?
      <a-button type="link" @click="onLogout">Click here</a-button>
    </div>
    <SignIn v-else="store.isLogin.value" />
  </div>
</template>
<script>
import { defineComponent, reactive, ref, inject, watch } from "vue";
import { logout } from "../../api/auth";
import { message } from "ant-design-vue";
// import { useRouter } from "vue-router";
import Cookies from "js-cookie";
import SignIn from "./signin.vue";

export default defineComponent({
  setup() {
    const store = inject("store");

    const onLogout = () => {
      logout()
        .then((resp) => {
          if (resp.status === 200) {
            message.success(resp.data.message);
            Cookies.remove("token", { path: "" });
            store.setUserState(null);
          }
        })
        .catch((error) => message.error(error.response.data.message));
    };

    return {
      onLogout,
      store,
    };
  },
  components: {
    SignIn,
  },
});
</script>
