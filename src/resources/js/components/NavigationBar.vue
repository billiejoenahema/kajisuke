<script setup>
import { computed, onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import { useStore } from 'vuex';
import CategoryListModal from './CategoryListModal';
import HouseworkCreateModal from './HouseworkCreateModal';

const props = defineProps({
  isLoading: Boolean,
  setIsLoading: Function,
});

const store = useStore();
const router = useRouter();
const profile = computed(() => store.getters['profile/profile']);
onMounted(async () => {
  await store.dispatch('profile/getIfNeeded');
  if (!isLogin.value) {
    router.push('/login');
  } else {
    props.setIsLoading(true);
    await store.dispatch('housework/get');
    props.setIsLoading(false);
    store.dispatch('category/get');
  }
});
const modalOpen = ref('');
const isLogin = computed(() => store.getters['profile/isLogin']);
const isShowUserMenu = ref(false);
const logout = () => {
  store.dispatch('auth/logout');
  router.push('/login');
};
const toHome = () => {
  router.push('/');
};
const setModalOpen = (prop) => {
  // prop: string
  modalOpen.value = prop;
};
const closeModal = () => {
  modalOpen.value = '';
};
const toggleShowUserMenu = () => {
  isShowUserMenu.value = !isShowUserMenu.value;
};
const hideShowUserMenu = () => {
  isShowUserMenu.value = false;
};
</script>

<template>
  <div @mouseleave="hideShowUserMenu()">
    <nav class="nav">
      <a href="#" @click.prevent="toHome()">Home</a>
      <a href="#" @click.prevent="setModalOpen('houseworkCreate')">Create HW</a>
      <a href="#" @click.prevent="setModalOpen('categoryList')"
        >Category List</a
      >
      <a class="nav-item-user" href="#" @click.prevent="toggleShowUserMenu()">{{
        profile.name
      }}</a>
    </nav>
    <div class="user-menu" v-if="isShowUserMenu">
      <div class="user-menu-item">Menu</div>
      <div class="user-menu-item">
        <router-link to="/profile">Profile</router-link>
      </div>
      <div class="user-menu-item">Settings</div>
      <div class="user-menu-item">Other</div>
      <div class="user-menu-item" @click="logout()">Logout</div>
    </div>
  </div>
  <HouseworkCreateModal
    v-if="modalOpen === 'houseworkCreate'"
    :closeModal="closeModal"
  />
  <CategoryListModal
    v-if="modalOpen === 'categoryList'"
    :closeModal="closeModal"
  />
</template>
