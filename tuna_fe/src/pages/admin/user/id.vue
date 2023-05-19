<template>
  <div class="d-flex gap-1">
    <a-avatar :size="100">
      <template #icon><UserOutlined /></template>
    </a-avatar>
    <a-form
      :model="userState"
      name="basic"
      :label-col="{ span: 5 }"
      :wrapper-col="{ span: 16 }"
      autocomplete="off"
      @finish="onFinish"
      class="flex-grow-1"
    >
      <a-form-item label="Name" name="name">
        <a-input v-model:value="userState.name" />
        <span class="text-danger" v-if="errors.name">
          {{ errors.name[0] }}
        </span>
      </a-form-item>

      <a-form-item label="Email" name="email">
        <a-input v-model:value="userState.email" />
        <span class="text-danger" v-if="errors.email">
          {{ errors.email[0] }}
        </span>
      </a-form-item>

      <a-form-item label="Created time">
        <span>{{ userState.created_at }}</span>
      </a-form-item>

      <a-form-item label="Updated time">
        <span>{{ userState.updated_at }}</span>
      </a-form-item>

      <a-button
        type="link"
        @click="() => (userState.changePassword = !userState.changePassword)"
        >Click to change password</a-button
      >
      <div v-if="userState.changePassword">
        <a-form-item label="New Password" name="password">
          <a-input-password v-model:value="userState.password" />
          <span class="text-danger" v-if="errors.password">
            {{ errors.password[0] }}
          </span>
        </a-form-item>

        <a-form-item label="Re new password" name="password_confirmation">
          <a-input-password v-model:value="userState.password_confirmation" />
          <span class="text-danger" v-if="errors.password">
            {{ errors.password[1] }}
          </span>
        </a-form-item>
      </div>

      <a-form-item :wrapper-col="{ offset: 16, span: 16 }">
        <a-button type="primary" html-type="submit">Submit</a-button>
      </a-form-item>
    </a-form>
  </div>
</template>

<script>
import { defineComponent, reactive, ref } from "vue";
import { updateUser, getAnUser } from "../../../api/user";
import { UserOutlined } from "@ant-design/icons-vue";
import { useRoute } from "vue-router";
import { message } from "ant-design-vue";
import dayjs from "dayjs";

export default defineComponent({
  setup() {
    const route = useRoute();
    const { id } = route.params;
    const errors = ref({});
    const userState = reactive({
      name: "",
      email: "",
      password: "",
      password_confirmation: "",
      changePassword: false,
      created_at: "",
      updated_at: "",
    });

    const onFinish = async (values) => {
      updateUser(values, id).then((resp) => {
        if (resp === "OK") {
          message.success("Chỉnh sửa thành công!");
        } else {
          errors.value = resp.errors;
        }
      });
    };

    getAnUser(id).then((data) => {
      (userState.name = data.name),
        (userState.id = data.id),
        (userState.created_at = dayjs(data.created_at).format(
          "DD/MM/YYYY, HH:mm:ss"
        )),
        (userState.updated_at = dayjs(data.updated_at).format(
          "DD/MM/YYYY, HH:mm:ss"
        )),
        (userState.email = data.email);
    });

    return {
      userState,
      errors,
      onFinish,
    };
  },
  components: {
    UserOutlined,
  },
});
</script>
