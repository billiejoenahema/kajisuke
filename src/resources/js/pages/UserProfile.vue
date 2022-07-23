<script setup>
import { computed, ref } from 'vue';
import { useStore } from 'vuex';
import NavigationBar from '../components/NavigationBar';

const store = useStore();

const user = computed(() => store.getters['user/user']);
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
      <li>ID: {{ user.id }}</li>
      <li>Name: {{ user.name }}</li>
    </ul>
  </div>
</template>
