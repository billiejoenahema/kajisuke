<script setup>
import { computed, reactive } from 'vue';
import { useStore } from 'vuex';
import { CYCLE_UNIT } from '../consts/cycle_unit';
import { ONE_MONTH_DATE_LIST } from '../consts/oneMonthDateList';

const props = defineProps({
  housework: {
    id: 0,
    user_id: 0,
    title: '',
    comment: '',
    cycle: {
      num: '',
      unit: '',
    },
    next_date: null,
    category: {
      id: 0,
      name: '',
    },
  },
  closeModal: Function,
});

const store = useStore();
const updatedHousework = reactive({
  id: props.housework.id,
  title: props.housework.title,
  comment: props.housework.comment,
  category_id: props.housework.category.id,
  cycle_num: props.housework.cycle.num,
  cycle_unit: props.housework.cycle.unit,
});
const categories = computed(() => store.getters['category/data']);
const updateHousework = async () => {
  console.log(updatedHousework);
  await store.dispatch('housework/update', updatedHousework);
  store.dispatch('housework/get');
  props.closeModal();
};
</script>

<template>
  <div class="modal" @click.self="closeModal()">
    <div class="housework-edit-area">
      <label>家事名</label>
      <input class="housework-title-input" v-model="updatedHousework.title" />
      <label>詳細</label>
      <textarea v-model="updatedHousework.comment" rows="8"></textarea>
      <div class="column">
        <label>実行周期</label>
        <div class="housework-cycle">
          <select v-model="updatedHousework.cycle_num">
            <option
              v-for="date in ONE_MONTH_DATE_LIST"
              :key="date"
              :value="'+' + date"
            >
              {{ date }}
            </option>
          </select>
          <select v-model="updatedHousework.cycle_unit">
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
        v-model="updatedHousework.category_id"
        name="category"
      >
        <option
          v-for="category in categories"
          :key="category.id"
          :value="category.id"
          :selected="category.id === updatedHousework.category_id"
        >
          {{ category.name }}
        </option>
      </select>
      <div class="store-button-area">
        <button class="store-button" @click="updateHousework()">
          更新する
        </button>
      </div>
    </div>
  </div>
</template>
