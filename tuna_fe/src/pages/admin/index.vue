<template>
  <div class="row">
    <div class="col-3">
      <Sidebar />
    </div>
    <div class="col-9 py-4">
      <router-view></router-view>
      <!-- <UserTable :userlist="userlist" /> -->
    </div>
  </div>
</template>

<script>
import Sidebar from "../../components/Sidebar.vue";
import UserTable from "./user/index.vue";
export default {
  components: {
    Sidebar,
    UserTable,
  },
  setup() {
    // const userlist = ref([]);
    // getAllUser().then((data) => (userlist.value = data));
    // return { userlist };
  },
};
</script>
