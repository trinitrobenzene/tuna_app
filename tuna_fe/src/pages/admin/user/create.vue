<template>
  <a-form
    :model="formState"
    name="basic"
    :label-col="{ span: 5 }"
    :wrapper-col="{ span: 16 }"
    autocomplete="off"
    @finish="onFinish"
  >
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
</template>

<script>
import { defineComponent, reactive, ref, toRefs } from "vue";
import { createNewUser } from "../../../api/user";
import { useRouter } from "vue-router";
import { message } from "ant-design-vue";

export default defineComponent({
  setup() {
    const router = useRouter();
    const errors = ref({});
    const formState = reactive({
      name: "",
      password: "",
      password_confirmation: "",
      email: "",
    });

    const onFinish = async (values) => {
      createNewUser(values).then((resp) => {
        if (resp.errors) {
          errors.value = resp.errors;
        } else {
          errors.value = {};
          message.success("Thêm thành công user!");
          router.push("/admin/users");
        }
      });
    };
    const onFinishFailed = (errorInfo) => {
      console.log("Failed:", errorInfo);
    };
    return {
      formState,
      errors,
      onFinish,
      onFinishFailed,
    };
  },
});
</script>
