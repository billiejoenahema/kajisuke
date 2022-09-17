<script setup>
import { computed, onMounted, reactive, ref } from 'vue';
import { useStore } from 'vuex';
import InvalidFeedback from '../components/InvalidFeedback.vue';
import NavigationBar from '../components/NavigationBar';
import ToastMessage from '../components/ToastMessage';
import { formatDate } from '../utilities/formatDate';

const store = useStore();

const user = reactive({
  id: null,
  name: '',
  email: '',
  profile: {
    image: '',
    first_name: '',
    last_name: '',
    gender: '0',
    birth: '',
    tel: '',
    zipcode1: '',
    zipcode2: '',
    prefecture: '',
    city: '',
    street_address: '',
  },
});
const inputRef = ref(null);
const inputFile = ref(null);
const isEditing = ref([]);
const isShowModal = ref(false);
const birthDate = reactive({});

const hasErrors = computed(() => store.getters['user/hasErrors']);
const invalidFeedback = computed(() => store.getters['user/invalidFeedback']);
const profileImagePath = computed(() => store.getters['user/profileImagePath']);
const years = computed(() => store.getters['consts/years']);
const months = computed(() => store.getters['consts/months']);
const days = computed(() => store.getters['consts/days']);
const genderFormOptions = computed(
  () => store.getters['consts/genderFormOptions']
);
const prefectureFormOptions = computed(
  () => store.getters['consts/prefectureFormOptions']
);
const genderTextValue = computed(() => store.getters['consts/genderTextValue']);
const prefectureTextValue = computed(
  () => store.getters['consts/prefectureTextValue']
);

onMounted(async () => {
  await store.dispatch('user/getIfNeeded');
  Object.assign(user, store.getters['user/user']);
  Object.assign(birthDate, store.getters['user/birthDate']);
});

const closeModal = () => {
  isShowModal.value = false;
};
const inputFileUrl = () => {
  return URL.createObjectURL(inputFile.value) ?? '';
};
const returnFileSize = (number) => {
  if (number < 1024) {
    return number + 'bytes';
  } else if (number >= 1024 && number < 1048576) {
    return (number / 1024).toFixed(1) + 'KB';
  } else if (number >= 1048576) {
    return (number / 1048576).toFixed(1) + 'MB';
  }
};
const onChangeInputFile = () => {
  inputFile.value = inputRef.value.files[0];
};
const updateProfileImage = async () => {
  setIsLoading(true);
  await store.dispatch('user/updateImage', inputFile.value);
  setIsLoading(false);
  if (hasErrors.value) return;
  await store.dispatch('user/get');
  Object.assign(user, store.getters['user/user']);
  isShowModal.value = false;
};
const toEdit = (prop) => {
  isEditing.value = [];
  isEditing.value = [...isEditing.value, prop];
};
const setIsLoading = (bool) => store.commit('loading/setIsLoading', bool);
const onChangeBirth = () => {
  user.profile.birth = `${birthDate.year}-${birthDate.month}-${birthDate.day}`;
};
const submit = async () => {
  isEditing.value = [];
  setIsLoading(true);
  await store.dispatch('user/update', user.profile);
  setIsLoading(false);
};
</script>

<template>
  <ToastMessage />
  <NavigationBar />
  <div v-if="isShowModal" class="modal" @click.self="closeModal()">
    <div class="column input-profile-image">
      <div class="modal-header">
        <div class="xmark-wrapper" @click="closeModal()">
          <font-awesome-icon class="xmark" icon="xmark" @click="closeModal()" />
        </div>
      </div>
      <input
        type="file"
        name="file"
        ref="inputRef"
        @change="onChangeInputFile"
      />
      <template v-if="inputFile">
        <div class="input-file">
          <img :src="inputFileUrl()" height="80" />
          <p>name: {{ inputFile.name }}</p>
          <p>size: {{ returnFileSize(inputFile.size) }}</p>
        </div>
      </template>
      <div v-else><img :src="profileImagePath(user.profile.image)" /></div>
      <div class="row between">
        <button @click="isShowModal = false">キャンセル</button>
        <button @click="updateProfileImage()" :disabled="!inputFile">
          更新する
        </button>
      </div>
    </div>
  </div>
  <h4>User Profile</h4>
  <div class="profile-image-wrapper column">
    <img
      class="profile-image"
      :src="profileImagePath(user.profile.image)"
      alt="profile image"
    />
    <font-awesome-icon
      class="pen-to-square-icon"
      icon="pen-to-square"
      title="プロフィール画像を変更する"
      @click="isShowModal = true"
    />
  </div>
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
      <select v-if="isEditing.includes('gender')" v-model="user.profile.gender">
        <option
          v-for="(gender, index) in genderFormOptions"
          :key="index"
          :value="gender.id"
        >
          {{ gender.name }}
        </option>
      </select>
      <div class="profile-item-value" v-else @click="toEdit('gender')">
        {{ genderTextValue(user.profile?.gender) }}
      </div>
    </li>
    <li class="profile-item">
      <label class="profile-item-label">生年月日:</label>
      <div v-if="isEditing.includes('birth')" class="birth-input row">
        <div class="year-select row">
          <select v-model="birthDate.year" @change="onChangeBirth()">
            <option v-for="(year, index) in years" :key="index" :value="year">
              {{ year }}
            </option>
          </select>
          <div>年</div>
        </div>
        <div class="month-select row">
          <select v-model="birthDate.month" @change="onChangeBirth()">
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
          <select v-model="birthDate.day" @change="onChangeBirth()">
            <option v-for="(day, index) in days" :key="index" :value="day">
              {{ day }}
            </option>
          </select>
          <div>日</div>
        </div>
      </div>
      <div class="profile-item-value" v-else @click="toEdit('birth')">
        {{ formatDate(user.profile?.birth) }}
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
          v-for="(prefecture, index) in prefectureFormOptions"
          :key="index"
          :value="prefecture.id"
        >
          {{ prefecture.name }}
        </option>
      </select>
      <div class="profile-item-value" v-else @click="toEdit('prefecture')">
        {{ prefectureTextValue(user.profile?.prefecture) }}
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
</template>
