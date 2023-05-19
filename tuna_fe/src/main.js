import { createApp } from "vue";
import "./style.css";
import App from "./App.vue";
import router from "./router";
import "bootstrap/dist/css/bootstrap.min.css";
import "ant-design-vue/dist/antd.css";
import Antd from "ant-design-vue";

const app = createApp(App);
app.use(router).use(Antd).mount("#app");
