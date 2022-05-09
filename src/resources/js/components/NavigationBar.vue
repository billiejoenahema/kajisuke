<script setup>
import { computed, onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import { useStore } from 'vuex';
import CategoryListModal from './CategoryListModal';
import HouseworkCreateModal from './HouseworkCreateModal';

const props = defineProps({
  userName: String,
  isLoading: Boolean,
  setIsLoading: Function,
});

const store = useStore();
const router = useRouter();

onMounted(async () => {
  await store.dispatch('profile/get');
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
const setModalOpen = (prop) => {
  // prop: string
  modalOpen.value = prop;
};
const closeModal = () => {
  modalOpen.value = '';
};
</script>

<template>
  <nav class="nav">
    <a href="/">Home</a>
    <a href="#" @click="setModalOpen('houseworkCreate')">Create HW</a>
    <a href="#" @click="setModalOpen('categoryList')">Category List</a>
    <a href="#" @click.prevent.stop="isShowUserMenu = !isShowUserMenu">{{
      userName
    }}</a>
  </nav>
  <div class="user-menu" v-if="isShowUserMenu">
    <div class="user-menu-item">Menu</div>
    <div class="user-menu-item">{{ userName }}</div>
    <div class="user-menu-item">Settings</div>
    <div class="user-menu-item">Other</div>
    <div class="user-menu-item" @click="logout()">Logout</div>
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
