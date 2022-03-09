import { createRouter, createWebHistory } from 'vue-router';
import HouseworkList from '../pages/HouseworkList';

const routes = [
  {
    path: '/',
    component: HouseworkList,
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
