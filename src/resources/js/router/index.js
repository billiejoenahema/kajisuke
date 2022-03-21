import { createRouter, createWebHistory } from 'vue-router';

const routes = [
  {
    path: '/',
    component: '',
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
