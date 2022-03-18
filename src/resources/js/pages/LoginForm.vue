<script setup>
import { reactive } from 'vue';
import { useRouter } from 'vue-router';
import { useStore } from 'vuex';

const store = useStore();
const router = useRouter();

const user = reactive({
  email: '',
  password: '',
});
const login = async () => {
  await store.dispatch('auth/login', user);
  //   await store.dispatch('loginUser/get');
  router.push('/');
};
</script>

<template>
  <form class="column">
    <div class="row"><h4>ログイン</h4></div>
    <div class="column">
      <label for="login-email">メールアドレス</label>
      <input v-model="user.email" id="login-email" name="email" type="email" />
    </div>
    <div class="column">
      <label for="login-password">パスワード</label>
      <input
        v-model="user.password"
        id="login-password"
        name="password"
        type="password"
      />
      <ul class="row">
        <li class="button submit" @click.prevent.stop="login">ログイン</li>
      </ul>
    </div>
  </form>
</template>
