<template>
  <div class="m-auto py-5">
    <a-form
      :model="formState"
      name="basic"
      :label-col="{ span: 4 }"
      autocomplete="off"
      @finish="onFinish"
    >
      <a-form-item label="Email" name="email">
        <a-input v-model:value="formState.email" />
      </a-form-item>

      <a-form-item label="Password" name="password">
        <a-input-password v-model:value="formState.password" />
      </a-form-item>

      <router-link to="/signup">To Sign Up</router-link>

      <a-form-item :wrapper-col="{ offset: 10, span: 20 }">
        <a-button type="primary" html-type="submit" class="w-50">
          Login
        </a-button>
      </a-form-item>
    </a-form>
  </div>
</template>

<script>
import { defineComponent, reactive, ref, watch, inject } from "vue";
import { login } from "../../api/auth";
import { message } from "ant-design-vue";
import { useRouter } from "vue-router";
import Cookies from "js-cookie";

export default defineComponent({
  setup() {
    const router = useRouter();
    const user = ref(null);
    const store = inject("store");
    const formState = reactive({
      email: "",
      password: "",
    });

    const onFinish = (values) => {
      login(values)
        .then((resp) => {
          if (resp.status === 200) {
            message.success("Đăng nhập thành công!");
            user.value = resp.data.user;
            Cookies.set("token", resp.data.token, { expires: 7 });
          }
        })
        .then(() => router.push("/admin/users"))
        .catch((error) => console.log(error));
    };

    watch(user, () => {
      store.setUserState(user.value);
    });

    return {
      formState,
      onFinish,
    };
  },
});
</script>
