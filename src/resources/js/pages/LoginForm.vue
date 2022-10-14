<script setup>
import { computed, reactive } from 'vue';
import { useRouter } from 'vue-router';
import { useStore } from 'vuex';
import InvalidFeedback from '../components/InvalidFeedback';
import ToastMessage from '../components/ToastMessage';

const router = useRouter();
const store = useStore();

const user = reactive({
  email: '',
  password: '',
});
const hasErrors = computed(() => store.getters['auth/hasErrors']);
const invalidFeedback = computed(() => store.getters['auth/invalidFeedback']);

const login = async () => {
  await store.dispatch('auth/login', user);
  if (!hasErrors.value) {
    router.push('/');
  }
};
</script>

<template>
  <ToastMessage />
  <form class="column login-form">
    <div class="login-title">Login Form</div>
    <p class="column">
      <label for="login-email">Email</label>
      <input v-model="user.email" id="login-email" name="email" type="email" />
      <InvalidFeedback :errors="invalidFeedback('email')" />
    </p>
    <p class="column">
      <label for="login-password">Password</label>
      <input
        v-model="user.password"
        id="login-password"
        name="password"
        type="password"
      />
      <InvalidFeedback :errors="invalidFeedback('password')" />
    </p>
    <button class="login-button" @click.prevent.stop="login()">Sign in</button>
  </form>
</template>
