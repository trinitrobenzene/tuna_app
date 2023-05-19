<template>
  <div>
    <div class="d-flex justify-content-end">
      <a-button @click="onExport"> Export as XSXL </a-button>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th>Id</th>
          <th>Name</th>
          <th>Email</th>
          <th>Role</th>
          <th></th>
        </tr>
      </thead>
      <tbody v-if="userlist">
        <tr v-for="user in userlist">
          <td>{{ user.id }}</td>
          <td>{{ user.name }}</td>
          <td>{{ user.email }}</td>
          <td>{{ user.is_admin }}</td>
          <td>
            <router-link :to="`/admin/user/${user.id}`">
              <a-button>Edit</a-button>
            </router-link>
            <a-button @click="() => deleteUser(user.id)" type="link">
              Delete
            </a-button>
            <a-button @click="() => onSendMail(user.id)" type="link">
              Send Mail
            </a-button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import { exportAllUser, getAllUser, removeUser } from "../../../api/user";
import { sendAd } from "../../../api/mail";
import { message } from "ant-design-vue";
import { ref } from "vue";

export default {
  setup() {
    const userlist = ref([]);
    const deleteUser = (id) => {
      removeUser(id).then((res) => {
        if (res === "OK") {
          message.success("Xóa thành công!");
          get();
        }
      });
    };
    const get = () => {
      getAllUser().then((data) => (userlist.value = data));
    };
    const onExport = () => {
      exportAllUser();
    };
    const onSendMail = (id) => {
      sendAd(id)
        .then((resp) => message.success("Gửi mail thành công!"))
        .catch((err) => console.log(err));
    };

    get();

    return { userlist, deleteUser, onExport, onSendMail };
  },
};
</script>
