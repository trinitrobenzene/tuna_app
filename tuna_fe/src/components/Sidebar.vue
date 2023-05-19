<template>
  <a-menu mode="vertical">
    <div class="border-bottom py-2">
      <h5>
        Login as <i>{{ user?.name }}</i>
      </h5>
      <p class="pt-2">ID: #{{ user?.id }}</p>
      <p>{{ user?.email }}</p>
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
import Cookies from "js-cookie";
import { useRouter } from "vue-router";
import { inject } from "vue";

export default {
  setup() {
    const router = useRouter();
    const { setUserState, user } = inject("store");
    function onLogout() {
      logout()
        .then((resp) => {
          if (resp.status === 200) {
            Cookies.remove("token", { path: "" });
            setUserState(null);
            message.success(resp.data.message);
          }
        })
        .then(() => router.push("/"))
        .catch((error) => console.log(error));
    }
    return { onLogout, user };
  },
};
</script>
