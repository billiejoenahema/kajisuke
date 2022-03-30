import { createRouter, createWebHistory } from 'vue-router';
import LoginForm from '../pages/LoginForm';
import MainPage from '../pages/MainPage';

const routes = [
  {
    path: '/',
    component: MainPage,
    meta: {
      isAuthenticated: true,
    },
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
