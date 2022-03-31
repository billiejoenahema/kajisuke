<script setup>
import { ref } from 'vue';

defineProps({
  userName: {
    type: String,
    required: true,
  },
});
const isShowUserMenu = ref(false);
</script>

<template>
  <nav class="nav">
    <a href="/">Home</a>
    <a href="#" @click.prevent.stop="isShowUserMenu = !isShowUserMenu">{{
      userName
    }}</a>
  </nav>
  <div class="user-menu" v-if="isShowUserMenu">
    <div>Menu</div>
    <div>{{ userName }}</div>
    <div>Settings</div>
    <div>Other</div>
  </div>
</template>
