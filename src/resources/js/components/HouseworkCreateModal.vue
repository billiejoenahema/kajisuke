<script setup>
import { computed, reactive } from 'vue';
import { useStore } from 'vuex';
import { CYCLE_UNIT } from '../consts/cycle_unit';
import { ONE_MONTH_DATE_LIST } from '../consts/oneMonthDateList';

const store = useStore();

const props = defineProps({
  closeModal: Function,
});

const categories = computed(() => store.getters['category/data']);
const housework = reactive({
  title: '',
  comment: '',
  cycle_num: '+1',
  cycle_unit: 'day',
  category_id: 0,
});
const storeHousework = async () => {
  await store.dispatch('housework/post', housework);
  // 正常に保存されたらリセットする
  resetHousework();
  props.closeModal();
  store.dispatch('housework/get');
};
const resetHousework = () => {
  housework.title = '';
  housework.comment = '';
  housework.cycle_num = '';
  housework.cycle_unit = '';
  housework.category_id = 0;
};
</script>

<template>
  <div class="modal" @click.self="closeModal()">
    <div class="housework-input-area">
      <label>家事名</label>
      <input class="housework-title-input" v-model="housework.title" />
      <label>詳細</label>
      <textarea v-model="housework.comment" rows="8"></textarea>
      <div class="column">
        <label>実行周期</label>
        <div class="housework-cycle">
          <select v-model="housework.cycle_num">
            <option
              v-for="date in ONE_MONTH_DATE_LIST"
              :key="date"
              :value="'+' + date"
            >
              {{ date }}
            </option>
          </select>
          <select v-model="housework.cycle_unit">
            <option v-for="item in CYCLE_UNIT" :value="item.value">
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
      <div class="store-button-area">
        <button class="store-button" @click="storeHousework()">作成する</button>
      </div>
    </div>
  </div>
</template>
