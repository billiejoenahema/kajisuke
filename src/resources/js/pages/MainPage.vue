<script setup>
import { computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useStore } from 'vuex';
import NavigationBar from '../components/NavigationBar';

const router = useRouter();
const store = useStore();

const profile = computed(() => store.getters['profile/profile']);

onMounted(async () => {
  await store.dispatch('profile/get');
  await store.dispatch('housework/get');
  const isLogin = computed(() => store.getters['profile/isLogin']);
  if (!isLogin.value) {
    router.push('/login');
  }
});
const houseworks = computed(() => store.getters['housework/data']);
</script>

<template>
  <NavigationBar :userName="profile.name" />
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
        <td>with two columns</td>
      </tr>
    </tbody>
  </table>
</template>
