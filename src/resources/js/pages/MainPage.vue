<script setup>
import { computed, ref } from 'vue';
import VueElementLoading from 'vue-element-loading';
import { useStore } from 'vuex';
import CategoryListModal from '../components/CategoryListModal';
import HouseworkCreateModal from '../components/HouseworkCreateModal';
import HouseworkList from '../components/HouseworkList';
import NavigationBar from '../components/NavigationBar';

const store = useStore();

const profile = computed(() => store.getters['profile/profile']);

const isLoading = ref(false);
const modalOpen = ref('');
const setIsLoading = (bool) => {
  isLoading.value = bool;
};
const setModalOpen = (prop) => {
  // prop: string
  modalOpen.value = prop;
};
const closeModal = () => {
  modalOpen.value = '';
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
  <div class="row">
    <button @click="setModalOpen('houseworkCreate')">家事を新規登録</button>
    <button @click="setModalOpen('categoryList')">カテゴリ一覧</button>
  </div>
  <HouseworkCreateModal
    v-if="modalOpen === 'houseworkCreate'"
    :closeModal="closeModal"
  />
  <CategoryListModal
    v-if="modalOpen === 'categoryList'"
    :closeModal="closeModal"
  />
  <HouseworkList v-if="!isLoading" />
</template>
