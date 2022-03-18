import { createRouter, createWebHistory } from 'vue-router';
import HouseworkList from '../pages/HouseworkList';
import LoginForm from '../pages/LoginForm';

const routes = [
  {
    path: '/',
    component: HouseworkList,
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
