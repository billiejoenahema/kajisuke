<script setup>
import { computed, onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import Loading from 'vue3-loading-overlay/dist/index';
import 'vue3-loading-overlay/dist/vue3-loading-overlay.css';
import { useStore } from 'vuex';
import CategoryListModal from '../components/Category/CategoryListModal';
import HouseworkCreateModal from '../components/Housework/HouseworkCreateModal';

const store = useStore();
const router = useRouter();
const user = computed(() => store.getters['user/user']);
const isLoading = computed(() => store.getters['loading/isLoading']);
const setIsLoading = (bool) => store.commit('loading/setIsLoading', bool);
onMounted(async () => {
  await store.dispatch('user/getIfNeeded');
  if (!isLogin.value) {
    router.push('/login');
  } else {
    setIsLoading(true);
    await store.dispatch('housework/getIfNeeded');
    setIsLoading(false);
    store.dispatch('consts/getIfNeeded');
    store.dispatch('category/getIfNeeded');
  }
});
const modalOpen = ref('');
const isLogin = computed(() => store.getters['user/isLogin']);
const isShowUserMenu = ref(false);
const logout = () => {
  if (confirm('ログアウトしますか？')) {
    store.dispatch('user/logout');
    router.push('/login');
  }
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
const moveToProfile = () => {
  isShowUserMenu.value = false;
  router.push('/profile');
};
</script>

<template>
  <Loading :active="isLoading" color="#FFF" opacity="0.1" />
  <div>
    <nav class="nav">
      <a href="#" @click.prevent="toHome()">Home</a>
      <a href="#" @click.prevent="setModalOpen('houseworkCreate')">Create HW</a>
      <a href="#" @click.prevent="setModalOpen('categoryList')"
        >Category List</a
      >
      <a
        class="nav-item-user"
        href="#"
        @click.prevent="isShowUserMenu = true"
        >{{ user.name }}</a
      >
      <teleport to="body">
        <div
          class="user-menu-back-drop"
          v-if="isShowUserMenu"
          @click.self="isShowUserMenu = false"
        >
          <div class="user-menu">
            <div class="user-menu-item">Menu</div>
            <div class="user-menu-item" @click="moveToProfile()">Profile</div>
            <div class="user-menu-item">Settings</div>
            <div class="user-menu-item">Other</div>
            <div class="user-menu-item logout" @click="logout()">Logout</div>
          </div>
        </div>
      </teleport>
    </nav>
  </div>
  <HouseworkCreateModal
    v-if="modalOpen === 'houseworkCreate'"
    :close-modal="closeModal"
  ></HouseworkCreateModal>
  <CategoryListModal
    v-if="modalOpen === 'categoryList'"
    :close-modal="closeModal"
  ></CategoryListModal>
</template>
