<script setup>
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import { computed, reactive } from 'vue';
import { useRouter } from 'vue-router';
import { useStore } from 'vuex';
import { CYCLE_UNIT } from '../consts/cycle_unit';
import { ONE_MONTH } from '../consts/oneMonthDateList';

const router = useRouter();
const store = useStore();

const props = defineProps({
  closeModal: Function,
});

const categories = computed(() => store.getters['category/data']);
const housework = reactive({
  title: '',
  comment: '',
  cycle_num: 1,
  cycle_unit: 1,
  next_date: '',
  category_id: 0,
});
const errors = computed(() => store.getters['housework/errors']);
const hasErrors = computed(() => store.getters['housework/hasErrors']);
const invalidFeedback = (attr) => {
  return attr ? attr[0] : '';
};
const storeHousework = async () => {
  await store.dispatch('housework/post', housework);
  if (hasErrors.value) {
    return;
  }
  // 正常に保存されたらリセットする
  resetHousework();
  props.closeModal();
  store.dispatch('housework/get');
  router.push('/');
};
const resetHousework = () => {
  housework.title = '';
  housework.comment = '';
  housework.cycle_num = 0;
  housework.cycle_unit = 0;
  housework.next_date = '';
  housework.category_id = null;
};
</script>

<template>
  <div class="modal" @click.self="closeModal()">
    <div class="housework-input-area">
      <div class="modal-header">
        <div class="xmark-wrapper" @click="closeModal()">
          <font-awesome-icon class="xmark" icon="xmark" />
        </div>
      </div>
      <label>家事名</label>
      <input class="housework-title-input" v-model="housework.title" />
      <div class="error-message">{{ invalidFeedback(errors.title) }}</div>
      <label>詳細</label>
      <textarea v-model="housework.comment" rows="8"></textarea>
      <div class="error-message">{{ invalidFeedback(errors.comment) }}</div>
      <div class="column">
        <label>初回実施日</label>
        <Datepicker
          class="date-picker"
          v-model="housework.next_date"
          format="yyyy/MM/dd"
          autoApply
        ></Datepicker>
        <div class="error-message">{{ invalidFeedback(errors.next_date) }}</div>
        <label>実行周期</label>
        <div class="housework-cycle">
          <select v-model="housework.cycle_num">
            <option v-for="day in ONE_MONTH.date_list" :key="day" :value="day">
              {{ day }}
            </option>
          </select>
          <select v-model="housework.cycle_unit">
            <option v-for="item in CYCLE_UNIT" :value="item.cycle_unit_id">
              {{ item.content }}
            </option>
          </select>
          <span> に一度</span>
        </div>
      </div>
      <label>カテゴリ</label>
      <select
        class="category-select"
        v-model="housework.category_id"
        name="category"
      >
        <option value="0">カテゴリを選択</option>
        <option
          v-for="category in categories"
          :key="category.id"
          :value="category.id"
        >
          {{ category.name }}
        </option>
      </select>
      <div class="error-message">{{ invalidFeedback(errors.category_id) }}</div>
      <div class="store-button-area">
        <button class="store-button" @click="storeHousework()">作成する</button>
      </div>
    </div>
  </div>
</template>
