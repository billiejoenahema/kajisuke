<script setup>
import { onMounted, reactive } from 'vue';
import { useRouter } from 'vue-router';
import { useStore } from 'vuex';

const router = useRouter();
const store = useStore();

const profile = reactive({
  id: 0,
  name: '',
  email: '',
});
onMounted(async () => {
  await store.dispatch('profile/get');
  await store.dispatch('houseworks/get');
  Object.assign(profile, store.getters['profile/data']);
  if (profile.id === 0) router.push('/login');
});
</script>

<template>
  <div>
    <H2>Housework List Page</H2>
  </div>
</template>
