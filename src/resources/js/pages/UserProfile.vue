<script setup>
import { computed, ref, watchEffect } from 'vue';
import VueElementLoading from 'vue-element-loading';
import { useStore } from 'vuex';
import NavigationBar from '../components/NavigationBar';
import ToastMessage from '../components/ToastMessage';
import { formatBirth } from '../utilities/formatBirth';
import { formatZipcode } from '../utilities/formatZipcode';

const store = useStore();
const user = computed(() => store.getters['user/user']);
const genderValues = computed(() => store.getters['consts/genderValues']);
const prefectures = computed(() => store.getters['consts/prefectures']);
const defaultGender = computed(() =>
  store.getters['consts/defaultGender'](user.value.profile?.gender)
);
const defaultPrefecture = computed(() =>
  store.getters['consts/defaultPrefecture'](user.value.profile?.prefecture)
);

const birthYear = ref('');
const birthMonth = ref('');
const birthDay = ref('');
watchEffect(() => {
  const birth = user.value.profile?.birth.split('-');
  if (birth) {
    birthYear.value = birth[0];
    birthMonth.value = birth[1];
    birthDay.value = birth[2];
  }
});
const errors = computed(() => store.getters['user/errors']);
const hasErrors = computed(() => store.getters['user/hasErrors']);
const isEditing = ref([]);
const toEdit = (prop) => {
  isEditing.value = [];
  isEditing.value = [...isEditing.value, prop];
};
const isLoading = ref(false);
const setIsLoading = (bool) => {
  isLoading.value = bool;
};
const onChangeBirth = () => {
  user.value.profile.birth = `${birthYear.value}-${birthMonth.value}-${birthDay.value}`;
};
const submit = async () => {
  isEditing.value = [];
  setIsLoading(true);
  await store.dispatch('user/update', user.value.profile);
  setIsLoading(false);
};
</script>

<template>
  <ToastMessage />
  <NavigationBar :isLoading="isLording" :setIsLoading="setIsLoading" />
  <vue-element-loading
    v-if="isLoading"
    :active="isLoading"
    color="#fff"
    background-color="rgba(0, 0, 0, 0)"
    spinner="spinner"
    is-full-screen
  />
  <div v-else>
    <h4>User Profile</h4>
    <ul>
      <li class="profile-item">
        <label class="profile-item-label">ID:</label>
        <div class="profile-item-value">{{ user.id }}</div>
      </li>
      <li class="profile-item">
        <label class="profile-item-label">ユーザーネーム:</label>
        <div class="profile-item-value">{{ user.name }}</div>
      </li>
      <li class="profile-item">
        <label class="profile-item-label">メールアドレス:</label>
        <div class="profile-item-value">{{ user.email }}</div>
      </li>
      <li class="profile-item">
        <label class="profile-item-label">姓:</label>
        <input
          v-if="isEditing.includes('last_name')"
          v-model="user.profile.last_name"
        />
        <div v-else @click="toEdit('last_name')">
          {{ user.profile?.last_name }}
        </div>
      </li>
      <li class="profile-item">
        <label class="profile-item-label">名:</label>
        <input
          v-if="isEditing.includes('first_name')"
          v-model="user.profile.first_name"
        />
        <div class="profile-item-value" v-else @click="toEdit('first_name')">
          {{ user.profile?.first_name }}
        </div>
      </li>
      <li class="profile-item">
        <label class="profile-item-label">性別:</label>
        <select
          v-if="isEditing.includes('gender')"
          v-model="user.profile.gender"
        >
          <option
            v-for="(gender, index) in genderValues"
            :key="index"
            :value="gender.id"
          >
            {{ gender.value }}
          </option>
        </select>
        <div class="profile-item-value" v-else @click="toEdit('gender')">
          {{ defaultGender }}
        </div>
      </li>
      <li class="profile-item">
        <label class="profile-item-label">生年月日:</label>
        <div v-if="isEditing.includes('birth')" class="birth-input row">
          <input v-model="birthYear" @change="onChangeBirth()" />
          <div>年</div>
          <input v-model="birthMonth" @change="onChangeBirth()" />
          <div>月</div>
          <input v-model="birthDay" @change="onChangeBirth()" />
          <div>日</div>
        </div>
        <div class="profile-item-value" v-else @click="toEdit('birth')">
          {{ formatBirth(user.profile?.birth) }}
        </div>
      </li>
      <li class="profile-item">
        <label class="profile-item-label">電話番号:</label>
        <input v-if="isEditing.includes('tel')" v-model="user.profile.tel" />
        <div class="profile-item-value" v-else @click="toEdit('tel')">
          {{ user.profile?.tel }}
        </div>
      </li>
      <li class="profile-item">
        <label class="profile-item-label">郵便番号:</label>
        <input
          v-if="isEditing.includes('zipcode')"
          v-model="user.profile.zipcode"
        />
        <div class="profile-item-value" v-else @click="toEdit('zipcode')">
          <span>〒</span>{{ formatZipcode(user.profile?.zipcode) }}
        </div>
      </li>
      <li class="profile-item">
        <label class="profile-item-label">都道府県:</label>
        <select
          v-if="isEditing.includes('prefecture')"
          v-model="user.profile.prefecture"
        >
          <option
            v-for="(prefecture, index) in prefectures"
            :key="index"
            :value="Object.keys(prefecture)[0]"
          >
            {{ Object.values(prefecture)[0] }}
          </option>
        </select>
        <div class="profile-item-value" v-else @click="toEdit('prefecture')">
          {{ defaultPrefecture }}
        </div>
      </li>
      <li class="profile-item">
        <label class="profile-item-label">市町村:</label>
        <input v-if="isEditing.includes('city')" v-model="user.profile.city" />
        <div class="profile-item-value" v-else @click="toEdit('city')">
          {{ user.profile?.city }}
        </div>
      </li>
      <li class="profile-item">
        <label class="profile-item-label">以下の住所:</label>
        <input
          v-if="isEditing.includes('street_address')"
          v-model="user.profile.street_address"
        />
        <div
          class="profile-item-value"
          v-else
          @click="toEdit('street_address')"
        >
          {{ user.profile?.street_address }}
        </div>
      </li>
    </ul>
    <button class="btn btn-primary" @click="submit()">更新</button>
  </div>
</template>
