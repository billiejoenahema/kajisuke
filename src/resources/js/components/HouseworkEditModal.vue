<script setup>
import { computed, reactive } from 'vue';
import { useStore } from 'vuex';
import { CYCLE_UNIT } from '../consts/cycle_unit';
import { ONE_MONTH } from '../consts/oneMonthDateList';

const props = defineProps({
  housework: {
    id: 0,
    user_id: 0,
    title: '',
    comment: '',
    cycle_num: 0,
    cycle_unit: 0,
    next_date: null,
    is_over_date: false,
    next_date: '',
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
  cycle_num: props.housework.cycle_num,
  cycle_unit: props.housework.cycle_unit,
});
const categories = computed(() => store.getters['category/data']);
const updateHousework = async () => {
  await store.dispatch('housework/update', updatedHousework);
  store.dispatch('housework/get');
  props.closeModal();
};
</script>

<template>
  <div class="modal" @click.self="closeModal()">
    <div class="housework-edit-area">
      <div class="modal-header">
        <div class="xmark-wrapper" @click="closeModal()">
          <font-awesome-icon class="xmark" icon="xmark" />
        </div>
      </div>
      <label>家事名</label>
      <input class="housework-title-input" v-model="updatedHousework.title" />
      <label>詳細</label>
      <textarea v-model="updatedHousework.comment" rows="8"></textarea>
      <div class="column">
        <label>実行周期</label>
        <div class="housework-cycle">
          <select v-model="updatedHousework.cycle_num">
            <option v-for="day in ONE_MONTH.date_list" :key="day" :value="day">
              {{ day }}
            </option>
          </select>
          <select v-model="updatedHousework.cycle_unit">
            <option
              v-for="item in CYCLE_UNIT"
              :value="item.cycle_unit_id"
              :selected="item.cycle_unit_id == updatedHousework.cycle_unit"
            >
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
        <button class="store-button" @click="updateHousework()">更新</button>
        <button class="cancel-button" @click="closeModal()">キャンセル</button>
      </div>
    </div>
  </div>
</template>
