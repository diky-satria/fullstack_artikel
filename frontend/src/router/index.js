import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/Home/HomeView.vue";
import MasterView from "../views/Master/MasterView";
import MasterViewTambah from "../views/Master/MasterViewTambah";
import MasterViewEdit from "../views/Master/MasterViewEdit";
import MasterViewDetail from "../views/Master/MasterViewDetail";
import HomeViewDetail from "../views/Home/HomeViewDetail";

const routes = [
  {
    path: "/",
    name: "home",
    component: HomeView,
  },
  {
    path: "/:id",
    name: "home_detail",
    component: HomeViewDetail,
  },
  {
    path: "/master",
    name: "master",
    component: MasterView,
  },
  {
    path: "/master/tambah",
    name: "master_tambah",
    component: MasterViewTambah,
  },
  {
    path: "/master/edit/:id",
    name: "master_edit",
    component: MasterViewEdit,
  },
  {
    path: "/master/detail/:id",
    name: "master_detail",
    component: MasterViewDetail,
  },
  {
    path: "/about",
    name: "about",
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () =>
      import(/* webpackChunkName: "about" */ "../views/AboutView.vue"),
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
