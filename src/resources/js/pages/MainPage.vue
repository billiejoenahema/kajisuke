<script setup>
import { computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useStore } from 'vuex';
import NavigationBar from '../components/NavigationBar.vue';

const router = useRouter();
const store = useStore();

const profile = computed(() => store.getters['profile/profile']);

onMounted(async () => {
  await store.dispatch('profile/get');
  const isLogin = computed(() => store.getters['profile/isLogin']);
  if (!isLogin.value) {
    router.push('/login');
  }
});
</script>

<template>
  <NavigationBar :userName="profile.name" />
  <div>Main Page</div>
  <div>UserName: {{ profile.name }}</div>
</template>
