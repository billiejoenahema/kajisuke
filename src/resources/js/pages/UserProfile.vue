<script setup>
import { computed, ref, watchEffect } from 'vue';
import { useStore } from 'vuex';
import InvalidFeedback from '../components/InvalidFeedback.vue';
import NavigationBar from '../components/NavigationBar';
import ToastMessage from '../components/ToastMessage';
import { formatBirth } from '../utilities/formatBirth';

const store = useStore();
const user = computed(() => store.getters['user/user']);
const genderValues = computed(() => store.getters['consts/genderValues']);
const prefectures = computed(() => store.getters['consts/prefectures']);
const years = computed(() => store.getters['consts/years']);
const months = computed(() => store.getters['consts/months']);
const days = computed(() => store.getters['consts/days']);
const currentGender = computed(() =>
  store.getters['consts/currentGender'](user.value.profile?.gender)
);
const currentPrefecture = computed(() =>
  store.getters['consts/currentPrefecture'](user.value.profile?.prefecture)
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
const invalidFeedback = computed(() => store.getters['user/invalidFeedback']);
const hasErrors = computed(() => store.getters['user/hasErrors']);
const isEditing = ref([]);
const toEdit = (prop) => {
  isEditing.value = [];
  isEditing.value = [...isEditing.value, prop];
};
const setIsLoading = (bool) => store.commit('loading/setIsLoading', bool);
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
  <NavigationBar />
  <div>
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
        <div v-if="isEditing.includes('last_name')">
          <input v-model="user.profile.last_name" maxlength="50" />
        </div>
        <div v-else>
          <div class="profile-item-value" @click="toEdit('last_name')">
            {{ user.profile?.last_name }}
          </div>
          <InvalidFeedback :errors="invalidFeedback('last_name')" />
        </div>
      </li>
      <li class="profile-item">
        <label class="profile-item-label">名:</label>
        <div v-if="isEditing.includes('first_name')">
          <input v-model="user.profile.first_name" maxlength="50" />
        </div>
        <div v-else>
          <div class="profile-item-value" @click="toEdit('first_name')">
            {{ user.profile?.first_name }}
          </div>
          <InvalidFeedback :errors="invalidFeedback('first_name')" />
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
          {{ currentGender }}
        </div>
      </li>
      <li class="profile-item">
        <label class="profile-item-label">生年月日:</label>
        <div v-if="isEditing.includes('birth')" class="birth-input row">
          <div class="year-select row">
            <select v-model="birthYear" @change="onChangeBirth()">
              <option v-for="(year, index) in years" :key="index" :value="year">
                {{ year }}
              </option>
            </select>
            <div>年</div>
          </div>
          <div class="month-select row">
            <select v-model="birthMonth" @change="onChangeBirth()">
              <option
                v-for="(month, index) in months"
                :key="index"
                :value="month"
              >
                {{ month }}
              </option>
            </select>
            <div>月</div>
          </div>
          <div class="day-select row">
            <select v-model="birthDay" @change="onChangeBirth()">
              <option v-for="(day, index) in days" :key="index" :value="day">
                {{ day }}
              </option>
            </select>
            <div>日</div>
          </div>
        </div>
        <div class="profile-item-value" v-else @click="toEdit('birth')">
          {{ formatBirth(user.profile?.birth) }}
        </div>
      </li>
      <li class="profile-item">
        <label class="profile-item-label">電話番号:</label>
        <input
          v-if="isEditing.includes('tel')"
          v-model="user.profile.tel"
          maxlength="13"
        />
        <div class="profile-item-value-column" v-else @click="toEdit('tel')">
          <span>{{ user.profile?.tel }}</span>
          <InvalidFeedback :errors="invalidFeedback('tel')" />
        </div>
      </li>
      <li class="profile-item">
        <label class="profile-item-label">住所:</label>
        <div class="column" v-if="isEditing.includes('zipcode')">
          <div class="row">
            <input
              class="zipcode1-input"
              v-model="user.profile.zipcode1"
              maxlength="3"
            />
            <span>-</span>
            <input
              class="zipcode2-input"
              v-model="user.profile.zipcode2"
              maxlength="4"
            />
          </div>
        </div>
        <div v-else>
          <div class="profile-item-value" @click="toEdit('zipcode')">
            <span>〒</span>{{ user.profile?.zipcode1 }}<span>-</span
            >{{ user.profile?.zipcode2 }}
          </div>
          <div class="row">
            <InvalidFeedback :errors="invalidFeedback('zipcode1')" />
            <InvalidFeedback :errors="invalidFeedback('zipcode2')" />
          </div>
        </div>
      </li>
      <li class="profile-item">
        <label class="profile-item-label"></label>
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
          {{ currentPrefecture }}
        </div>
      </li>
      <li class="profile-item">
        <label class="profile-item-label"></label>
        <div v-if="isEditing.includes('city')">
          <input v-model="user.profile.city" maxlength="50" />
        </div>
        <div v-else>
          <div class="profile-item-value" @click="toEdit('city')">
            {{ user.profile?.city }}
          </div>
          <InvalidFeedback :errors="invalidFeedback('city')" />
        </div>
      </li>
      <li class="profile-item">
        <label class="profile-item-label"></label>
        <div v-if="isEditing.includes('street_address')">
          <input v-model="user.profile.street_address" maxlength="50" />
        </div>
        <div v-else>
          <div class="profile-item-value" @click="toEdit('street_address')">
            {{ user.profile?.street_address }}
          </div>
          <InvalidFeedback :errors="invalidFeedback('street_address')" />
        </div>
      </li>
    </ul>
    <button class="btn btn-primary" @click="submit()">更新</button>
  </div>
</template>
