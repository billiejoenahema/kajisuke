import { createRouter, createWebHistory } from 'vue-router';
import Home from '../pages/Home.vue';
import LoginForm from '../pages/LoginForm.vue';

const routes = [
  {
    path: '/',
    component: Home,
  },
  {
    path: '/login',
    component: LoginForm,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes: routes,
  scrollBehavior() {
    return { x: 0, y: 0 };
  },
});

export default router;
