<script setup>
import { computed, onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import { useStore } from 'vuex';
import CategoryListModal from '../components/Category/CategoryListModal';
import HouseworkCreateModal from '../components/Housework/HouseworkCreateModal';

const props = defineProps({
  isLoading: Boolean,
  setIsLoading: Function,
});

const store = useStore();
const router = useRouter();
const user = computed(() => store.getters['user/user']);
onMounted(async () => {
  await store.dispatch('user/getIfNeeded');
  if (!isLogin.value) {
    router.push('/login');
  } else {
    props.setIsLoading(true);
    await store.dispatch('housework/getIfNeeded');
    await store.dispatch('consts/getIfNeeded');
    props.setIsLoading(false);
    store.dispatch('category/getIfNeeded');
  }
});
const modalOpen = ref('');
const isLogin = computed(() => store.getters['user/isLogin']);
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
        user.name
      }}</a>
    </nav>
    <div class="user-menu" v-if="isShowUserMenu">
      <div class="user-menu-item">Menu</div>
      <router-link class="user-menu-item" to="/profile">Profile</router-link>
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
