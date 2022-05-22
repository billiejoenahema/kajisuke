<script setup>
import { computed } from 'vue';
import { useStore } from 'vuex';
import NavigationBar from '../components/NavigationBar';
const store = useStore();
const profile = computed(() => store.getters['profile/profile']);
</script>

<template>
  <NavigationBar
    :userName="profile.name"
    :isLoading="isLoading"
    :setIsLoading="setIsLoading"
  />
  <div>
    <h4>User Profile</h4>
    <ul>
      <li>User ID: {{ profile.id }}</li>
      <li>User Name: {{ profile.name }}</li>
    </ul>
  </div>
</template>
