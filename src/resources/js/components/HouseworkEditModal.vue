<script setup>
import { computed, reactive } from 'vue';
import { useStore } from 'vuex';

const props = defineProps({
  housework: {
    type: Object,
    required: true,
  },
  closeModal: {
    type: Function,
    required: true,
  },
  cycleNumbers: {
    type: Array,
    required: true,
  },
});

const store = useStore();
const updatedHousework = reactive({
  id: props.housework.id,
  title: props.housework.title,
  comment: props.housework.comment,
  category: props.housework.category,
  cycle_num: props.housework.cycle_num,
  next_date: props.housework.next_date,
});
const categories = computed(() => store.getters['category/data']);
const updateHousework = () => {
  props.closeModal();
};
</script>

<template>
  <div class="modal" @click.self="closeModal()">
    <div class="housework-edit-area">
      <label>家事名</label>
      <input class="housework-title-input" v-model="housework.title" />
      <label>詳細</label>
      <textarea v-model="housework.comment" rows="8"></textarea>
      <div class="column">
        <label>実行周期</label>
        <div class="housework-cycle">
          <select v-model="housework.cycle.num">
            <option v-for="num in cycleNumbers" :key="num" :value="'+' + num">
              {{ num }}
            </option>
          </select>
          <select v-model="housework.cycle.unit">
            <option value="day">日</option>
            <option value="week">週</option>
            <option value="month">月</option>
            <option value="year">年</option>
          </select>
          <span> に一度</span>
        </div>
      </div>
      <label>カテゴリ</label>
      <select
        class="category-select"
        v-model="housework.category.id"
        name="category"
      >
        <option
          v-for="category in categories"
          :key="category.id"
          :value="category.id"
          :selected="category.id === housework.category.id"
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
