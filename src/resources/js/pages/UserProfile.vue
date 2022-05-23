<script setup>
import { computed, ref } from 'vue';
import { useStore } from 'vuex';
import NavigationBar from '../components/NavigationBar';

const store = useStore();

const profile = computed(() => store.getters['profile/profile']);
const isLoading = ref(false);
const setIsLoading = (bool) => {
  isLoading.value = bool;
};
</script>

<template>
  <NavigationBar :isLoading="isLording" :setIsLoading="setIsLoading" />
  <div>
    <h4>User Profile</h4>
    <ul>
      <li>User ID: {{ profile.id }}</li>
      <li>User Name: {{ profile.name }}</li>
    </ul>
  </div>
</template>
