<script setup>
import { computed, onMounted, ref } from 'vue';
import VueElementLoading from 'vue-element-loading';
import { useRouter } from 'vue-router';
import { useStore } from 'vuex';
import HouseworkCreateModal from '../components/HouseworkCreateModal.vue';
import NavigationBar from '../components/NavigationBar';

const router = useRouter();
const store = useStore();

const profile = computed(() => store.getters['profile/profile']);
const isLogin = computed(() => store.getters['profile/isLogin']);
const isLoading = ref(false);
const isModalOpen = ref(false);
const houseworks = computed(() => store.getters['housework/data']);

const closeModal = () => {
  isModalOpen.value = false;
};

onMounted(async () => {
  await store.dispatch('profile/get');
  if (!isLogin.value) {
    router.push('/login');
  } else {
    isLoading.value = true;
    await store.dispatch('housework/get');
    isLoading.value = false;
  }
});
</script>

<template>
  <NavigationBar :userName="profile.name" />
  <vue-element-loading
    v-if="isLogin"
    :active="isLoading"
    color="#fff"
    background-color="rgba(0, 0, 0, 0)"
    spinner="spinner"
    is-full-screen
  />
  <div><button @click="isModalOpen = true">新規作成</button></div>
  <HouseworkCreateModal v-if="isModalOpen" :closeModal="closeModal" />
  <table>
    <thead>
      <tr>
        <th class="title">家事</th>
        <th class="schedule">----------- スケジュール -----------</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="item in houseworks" :key="item.id">
        <td>{{ item.title }}</td>
        <td>{{ item.comment }}</td>
      </tr>
    </tbody>
  </table>
</template>
