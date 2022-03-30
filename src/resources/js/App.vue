<script setup>
import axios from 'axios';
import { reactive } from 'vue';
const user = reactive({
  email: '',
  password: '',
});
const login = async () => {
  console.log(user);
  await axios
    .get('http://localhost:8080/sanctum/csrf-cookie')
    .then(async (res) => {
      console.log(res.status);
      await axios
        .post('/login', user)
        .then((res) => {
          console.log(res.status);
        })
        .catch((err) => {
          console.log(err.message);
        });
    });
};
const getProfile = async () => {
  await axios
    .get('/api/profile')
    .then((res) => {
      console.log(res.data);
    })
    .catch((err) => {
      console.log(err);
    });
};
</script>

<template>
  <form class="column login-form">
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
      <button class="button submit" @click.prevent.stop="login()">
        ログイン
      </button>
      <button class="button submit" @click.prevent.stop="getProfile()">
        Get profile.
      </button>
    </div>
  </form>
</template>
