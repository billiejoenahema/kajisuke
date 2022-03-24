<script setup>
import { useRouter } from 'vue-router';
import { useStore } from 'vuex';

const store = useStore();
const router = useRouter();

const logout = () => {
  store.dispatch('auth/logout');
  router.push('/login');
};
</script>

<template>
  <nav>
    <button @click="logout()">logout</button>
  </nav>
</template>
