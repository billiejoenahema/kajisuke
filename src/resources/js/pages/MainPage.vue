<script setup>
import { useStore } from 'vuex';
import HouseworkList from '../components/Housework/HouseworkList';
import NavigationBar from '../components/NavigationBar';
import ToastMessage from '../components/ToastMessage';

const store = useStore();
const isLoading = store.getters['loading/isLoading'];
</script>

<template>
  <ToastMessage />
  <NavigationBar />

  <HouseworkList v-if="!isLoading" />
</template>
