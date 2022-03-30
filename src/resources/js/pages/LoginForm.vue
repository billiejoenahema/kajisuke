<script setup>
import { computed, reactive } from 'vue';
import { useRouter } from 'vue-router';
import { useStore } from 'vuex';

const router = useRouter();
const store = useStore();

const user = reactive({
  email: '',
  password: '',
});
const hasErrors = computed(() => store.getters['auth/hasErrors']);

const login = async () => {
  await store.dispatch('auth/login', user);
  if (!hasErrors.value) {
    router.push('/');
  }
};
</script>

<template>
  <form class="column login-form">
    <div class="column">
      <label for="login-email">Email</label>
      <input v-model="user.email" id="login-email" name="email" type="email" />
    </div>
    <div class="column">
      <label for="login-password">Password</label>
      <input
        v-model="user.password"
        id="login-password"
        name="password"
        type="password"
      />
      <button class="button submit" @click.prevent.stop="login()">
        Sign in
      </button>
    </div>
  </form>
</template>
