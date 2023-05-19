import Admin from "../pages/admin/index.vue";
import AdminUser from "../pages/admin/user/index.vue";
import CreateUser from "../pages/admin/user/create.vue";
import EditUser from "../pages/admin/user/id.vue";

const admin = [
  {
    path: "/admin",
    name: "admin",
    component: Admin,
    children: [
      {
        path: "add",
        name: "admin-add-user",
        component: CreateUser,
      },
      {
        path: "users",
        name: "admin-users",
        component: AdminUser,
      },
      {
        path: "user/:id",
        name: "edit-users",
        component: EditUser,
      },
    ],
  },
];

export default admin;
