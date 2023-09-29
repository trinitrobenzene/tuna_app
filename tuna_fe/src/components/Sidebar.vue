<template>
  <a-menu mode="vertical">
    <div class="border-bottom py-2" v-if="user">
      <h5>
        Login as <i>{{ user.name }}</i>
      </h5>
      <p class="pt-2">ID: #{{ user.id }}</p>
      <p>{{ user.email }}</p>
    </div>
    <a-menu-item key="1">
      <router-link to="/admin/users">View All user</router-link>
    </a-menu-item>
    <a-menu-item key="2">
      <router-link to="/admin/add">Create New User</router-link>
    </a-menu-item>
    <a-menu-item key="3">
      <a-button @click="onLogout">Đăng xuất</a-button>
    </a-menu-item>
  </a-menu>
</template>

<script>
import { message } from "ant-design-vue";
import { logout } from "../api/auth";
import { useRouter } from "vue-router";
import { inject, watchEffect, watch } from "vue";
import Cookies from "js-cookie";

export default {
  setup() {
    const router = useRouter();
    const { setUserState, user } = inject("store");

    const onLogout = () => {
      logout()
        .then((resp) => {
          if (resp.status === 200) {
            message.success(resp.data.message);
            Cookies.remove("token", { path: "" });
            setUserState(null);
          }
          router.push("/");
        })
        .catch((error) => message.error(error.response.data.message));
    };

    // watch(() => {
    //   console.log(user.value);
    //   if (user.value) console.log(user.value.name);
    // });

    return { onLogout, user };
  },
};
</script>
