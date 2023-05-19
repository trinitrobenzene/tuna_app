<template>
  <div class="w-75 m-auto py-5">
    <a-form
      :model="formState"
      name="basic"
      :label-col="{ span: 5 }"
      :wrapper-col="{ span: 16 }"
      autocomplete="off"
      @finish="onFinish"
    >
      <h3 class="text-center">Sign up your admin account</h3>
      <a-form-item label="Name" name="name">
        <a-input v-model:value="formState.name" />
        <span class="text-danger" v-if="errors.name">
          {{ errors.name[0] }}
        </span>
      </a-form-item>

      <a-form-item label="Email" name="email">
        <a-input v-model:value="formState.email" />
        <span class="text-danger" v-if="errors.email">
          {{ errors.email[0] }}
        </span>
      </a-form-item>

      <a-form-item label="Password" name="password">
        <a-input-password v-model:value="formState.password" />
        <span class="text-danger" v-if="errors.password">
          {{ errors.password[0] }}
        </span>
      </a-form-item>

      <a-form-item label="Re password" name="password_confirmation">
        <a-input-password v-model:value="formState.password_confirmation" />
        <span class="text-danger" v-if="errors.password">
          {{ errors.password[1] }}
        </span>
      </a-form-item>

      <a-form-item :wrapper-col="{ offset: 16, span: 16 }">
        <a-button type="primary" html-type="submit">Submit</a-button>
      </a-form-item>
    </a-form>
  </div>
</template>

<script>
import { defineComponent, reactive, ref, inject } from "vue";
import { useRouter } from "vue-router";
import { message } from "ant-design-vue";
import { register } from "../../api/auth";
import jsCookie from "js-cookie";

export default defineComponent({
  setup() {
    const router = useRouter();
    const errors = ref({});
    const { setUserState } = inject("store");
    const formState = reactive({
      email: "",
      name: "",
      password: "",
      password_confirmation: "",
    });

    const onFinish = (values) => {
      register(values)
        .then((resp) => {
          message.success("Đăng ký thành công!");
          jsCookie.set("token", resp.data.token);
          setUserState(resp.data.user);
        })
        .then(() => router.push("/admin/users"))
        .catch((err) => console.log(err));
    };
    return {
      formState,
      errors,
      onFinish,
    };
  },
});
</script>
