<script setup>
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import { computed } from 'vue';
import { useStore } from 'vuex';
import { CYCLE_UNIT } from '../consts/cycle_unit';
import { ONE_MONTH } from '../consts/oneMonthDateList';

const props = defineProps({
  id: Number,
  closeModal: Function,
});

const store = useStore();
const housework = computed(() => store.getters['housework/item'](props.id));
const categories = computed(() => store.getters['category/data']);
const errors = computed(() => store.getters['housework/errors']);
const hasErrors = computed(() => store.getters['housework/hasErrors']);
const updateHousework = async () => {
  await store.dispatch('housework/update', housework.value);
  if (hasErrors.value) {
    return;
  }
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
      <input class="housework-title-input" v-model="housework.title" />
      <label>詳細</label>
      <textarea v-model="housework.comment" rows="8"></textarea>
      <div class="column">
        <label>実行周期</label>
        <div class="housework-cycle">
          <select v-model="housework.cycle_num">
            <option v-for="day in ONE_MONTH.date_list" :key="day" :value="day">
              {{ day }}
            </option>
          </select>
          <select v-model="housework.cycle_unit">
            <option
              v-for="item in CYCLE_UNIT"
              :value="item.cycle_unit_id"
              :selected="item.cycle_unit_id == housework.cycle_unit"
            >
              {{ item.content }}
            </option>
          </select>
          <span> に一度</span>
        </div>
      </div>
      <label>初回実施日</label>
      <Datepicker
        class="date-picker"
        v-model="housework.next_date"
        format="yyyy/MM/dd"
        autoApply
      ></Datepicker>
      <label>カテゴリ</label>
      <select
        class="category-select"
        v-model="housework.category_id"
        name="category"
      >
        <option
          v-for="category in categories"
          :key="category.id"
          :value="category.id"
          :selected="category.id === housework.category_id"
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
