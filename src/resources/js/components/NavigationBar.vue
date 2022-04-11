<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useStore } from 'vuex';

defineProps({
  userName: {
    type: String,
    required: true,
  },
});
const router = useRouter();
const store = useStore();

const isShowUserMenu = ref(false);
const logout = () => {
  store.dispatch('auth/logout');
  router.push('/login');
};
</script>

<template>
  <nav class="nav">
    <a href="/">Home</a>
    <a href="#" @click.prevent.stop="isShowUserMenu = !isShowUserMenu">{{
      userName
    }}</a>
  </nav>
  <div class="user-menu" v-if="isShowUserMenu">
    <div class="user-menu-item">Menu</div>
    <div class="user-menu-item">{{ userName }}</div>
    <div class="user-menu-item">Settings</div>
    <div class="user-menu-item">Other</div>
    <div class="user-menu-item" @click="logout()">Logout</div>
  </div>
</template>
