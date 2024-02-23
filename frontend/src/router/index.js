// import Vue from "vue";
// import VueRouter from "vue-router";

import { createRouter, createWebHistory } from "vue-router";

//Vue.use(VueRouter);
const routes = [
  {
    path: "/siswa",
    name: "siswa.index",
    component: () => import("@/views/siswa/Index.vue"),
    beforeEnter: (to, from, next) => {
      const token = localStorage.getItem("token");
      if (!token) {
        next({ name: "login" });
      } else {
        next();
      }
    },
  },
  {
    path: "/create",
    name: "siswa.create",
    component: () => import("@/views/siswa/Create.vue"),
    beforeEnter: (to, from, next) => {
      const token = localStorage.getItem("token");
      if (!token) {
        next({ name: "login" });
      } else {
        if (localStorage.getItem("role") !== "admin") {
          next({ name: "siswa.index" });
        } else {
          next();
        }
      }
    },
  },
  {
    path: "/edit/:id",
    name: "siswa.edit",
    component: () => import("@/views/siswa/Edit.vue"),
    beforeEnter: (to, from, next) => {
      const token = localStorage.getItem("token");
      if (!token) {
        next({ name: "login" });
      } else {
        if (localStorage.getItem("role") !== "admin") {
          next({ name: "siswa.index" });
        } else {
          next();
        }
      }
    },
  },
  {
    path: "/",
    name: "index",
    component: () => import("@/views/auth/Login.vue"),
    beforeEnter: (to, from, next) => {
      const token = localStorage.getItem("token");
      if (!token) {
        next({ name: "login" });
      } else {
        next({ name: "siswa.index" });
      }
    },
  },
  {
    path: "/login",
    name: "login",
    component: () => import("@/views/auth/Login.vue"),
    beforeEnter: (to, from, next) => {
      const token = localStorage.getItem("token");
      if (token) {
        next({ name: "siswa.index" });
      } else {
        next();
      }
    },
  },
  {
    path: "/register",
    name: "register",
    component: () => import("@/views/auth/Register.vue"),
    beforeEnter: (to, from, next) => {
      const token = localStorage.getItem("token");
      if (token) {
        next({ name: "siswa.index" });
      } else {
        next();
      }
    },
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes, // config routes
});
export default router;
