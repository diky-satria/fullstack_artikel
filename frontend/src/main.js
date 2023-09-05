import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";

// bootstrap
import "bootstrap";
import "bootstrap/dist/css/bootstrap.min.css";

// css
import "./styles/style.css";

// ckeditor
import CKEditor from "@ckeditor/ckeditor5-vue";
import axios from "axios";

axios.interceptors.request.use(function (config) {
  config.baseURL = process.env.VUE_APP_URL_API;
  return config;
});

createApp(App).use(router).use(CKEditor).mount("#app");
