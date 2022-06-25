<script setup>
import { ref } from 'vue';
import VueElementLoading from 'vue-element-loading';
import HouseworkList from '../components/HouseworkList';
import NavigationBar from '../components/NavigationBar';
import ToastMessage from '../components/ToastMessage';

const isLoading = ref(false);
const setIsLoading = (bool) => {
  isLoading.value = bool;
};
</script>

<template>
  <ToastMessage />
  <NavigationBar :isLoading="isLording" :setIsLoading="setIsLoading" />
  <vue-element-loading
    v-if="isLoading"
    :active="isLoading"
    color="#fff"
    background-color="rgba(0, 0, 0, 0)"
    spinner="spinner"
    is-full-screen
  />
  <HouseworkList v-if="!isLoading" />
</template>
