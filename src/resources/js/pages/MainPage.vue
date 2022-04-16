<script setup>
import { computed, ref } from 'vue';
import VueElementLoading from 'vue-element-loading';
import { useStore } from 'vuex';
import HouseworkCreateModal from '../components/HouseworkCreateModal';
import HouseworkList from '../components/HouseworkList';
import NavigationBar from '../components/NavigationBar';

const store = useStore();

const profile = computed(() => store.getters['profile/profile']);

const isLoading = ref(false);
const isModalOpen = ref(false);
const setIsLoading = (bool) => {
  isLoading.value = bool;
};
const closeModal = () => {
  isModalOpen.value = false;
};
</script>

<template>
  <NavigationBar
    :userName="profile.name"
    :isLoading="isLoading"
    :setIsLoading="setIsLoading"
  />
  <vue-element-loading
    v-if="isLoading"
    :active="isLoading"
    color="#fff"
    background-color="rgba(0, 0, 0, 0)"
    spinner="spinner"
    is-full-screen
  />
  <div><button @click="isModalOpen = true">新規作成</button></div>
  <HouseworkCreateModal v-if="isModalOpen" :closeModal="closeModal" />
  <HouseworkList />
</template>
