<script setup>
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import { computed, onMounted, reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
import { useStore } from 'vuex';
import { ONE_MONTH } from '../../consts/oneMonthDateList';
import CharacterCounter from '../CharacterCounter';
import InvalidFeedback from '../InvalidFeedback';

const router = useRouter();
const store = useStore();

const props = defineProps({
  closeModal: Function,
});
const cycleUnitFormOptions = computed(
  () => store.getters['consts/cycleUnitFormOptions']
);
const maxLength = computed(() => store.getters['consts/maxLength']);
const categories = computed(() => store.getters['category/data']);
const housework = reactive({
  title: '',
  comment: '',
  cycle_num: 1,
  cycle_unit: 1,
  next_date: '',
  category_id: 0,
});
const invalidFeedback = computed(
  () => store.getters['housework/invalidFeedback']
);
const titleRef = ref(null);
onMounted(() => {
  titleRef.value.focus();
});
const hasErrors = computed(() => store.getters['housework/hasErrors']);
const setIsLoading = (bool) => store.commit('loading/setIsLoading', bool);
const storeHousework = async () => {
  setIsLoading(true);
  await store.dispatch('housework/post', housework);
  setIsLoading(false);
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
      <input
        class="housework-title-input"
        :class="invalidFeedback('title') && 'invalid'"
        v-model="housework.title"
        :maxlength="maxLength('housework_title')"
        ref="titleRef"
      />
      <InvalidFeedback :errors="invalidFeedback('title')"></InvalidFeedback>
      <CharacterCounter
        :character="housework.title"
        :max-length="maxLength('housework_title') ?? 0"
      ></CharacterCounter>
      <label>詳細</label>
      <textarea
        :class="invalidFeedback('comment') && 'invalid'"
        v-model="housework.comment"
        rows="8"
        :maxlength="maxLength('housework_comment')"
      ></textarea>
      <InvalidFeedback :errors="invalidFeedback('comment')"></InvalidFeedback>
      <CharacterCounter
        :character="housework.comment"
        :max-length="maxLength('housework_comment') ?? 0"
      ></CharacterCounter>
      <div class="column">
        <label>初回実施日</label>
        <Datepicker
          class="date-picker"
          :class="invalidFeedback('next_date') && 'invalid'"
          v-model="housework.next_date"
          format="yyyy/MM/dd"
          autoApply
        ></Datepicker>
        <InvalidFeedback
          :errors="invalidFeedback('next_date')"
        ></InvalidFeedback>
        <label>実行周期</label>
        <div class="housework-cycle">
          <select v-model="housework.cycle_num">
            <option v-for="day in ONE_MONTH.date_list" :key="day" :value="day">
              {{ day }}
            </option>
          </select>
          <select v-model="housework.cycle_unit">
            <option v-for="item in cycleUnitFormOptions" :value="item.id">
              {{ item.name }}
            </option>
          </select>
          <span> に一度</span>
        </div>
      </div>
      <label>カテゴリ</label>
      <select
        class="category-select"
        :class="invalidFeedback('category_id') && 'invalid'"
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
      <InvalidFeedback
        :errors="invalidFeedback('category_id')"
      ></InvalidFeedback>
      <div class="store-button-area">
        <button class="store-button" @click="storeHousework()">作成する</button>
      </div>
    </div>
  </div>
</template>
