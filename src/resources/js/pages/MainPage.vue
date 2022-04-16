<script setup>
import { computed, onMounted, ref } from 'vue';
import { VueDraggableNext as draggable } from 'vue-draggable-next';
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
const sortedHouseworks = ref([]);

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
const changeOrder = async () => {
  await store.dispatch('houseworkOrder/patch', newOrderIds(houseworks.value));
};
const newOrderIds = (houseworks) => {
  const ids = houseworks.map((item) => {
    return item.id;
  });
  return ids.join();
};
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
  <div class="column list-body">
    <div class="row list-header">
      <div class="title">家事</div>
      <div class="schedule">----------- スケジュール -----------</div>
    </div>
    <draggable
      class="dragArea list-group w-full"
      group="housework"
      :list="houseworks"
      sort="true"
      @end="changeOrder()"
      v-model="houseworks"
    >
      <div
        class="list-group-item row"
        v-for="item in houseworks"
        :key="item.id"
      >
        <div class="column title">
          <div class="housework-title">
            <mark v-for="category in item.categories" :key="category.id">{{
              category.name
            }}</mark>
          </div>
          <div>{{ item.title }}</div>
        </div>
        <div class="schedule">{{ item.comment }}</div>
      </div>
    </draggable>
  </div>
</template>
