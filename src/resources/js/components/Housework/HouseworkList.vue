<script setup>
import { computed, reactive, ref } from 'vue';
import { useStore } from 'vuex';
import Calendar from '../Calender/Calendar.vue';
import SortIcon from '../SortIcon';
import HouseworkListItem from './HouseworkListItem';

const store = useStore();
const houseworks = computed(() => store.getters['housework/data']);
const isCalendarView = ref(false);
const sort = reactive({
  column: '',
  is_ascending: false,
});
const isAscending = reactive({
  ...initialIsAscending,
});
const initialIsAscending = () => {
  isAscending.title = false;
  isAscending.comment = false;
  isAscending.cycle_unit = false;
  isAscending.next_date = false;
};
const resetWord = () => {
  return sort.column === '' ? '' : '並び順をリセット';
};
const resetSort = () => {
  sort.column = '';
  sort.is_ascending = false;
  initialIsAscending();
  store.dispatch('housework/get');
};
const sortOrder = (value) => {
  if (value === sort.column) {
    sort.is_ascending = !sort.is_ascending;
  } else {
    sort.column = value;
    sort.is_ascending = true;
    initialIsAscending();
  }
  isAscending[value] = sort.is_ascending;
  store.dispatch('housework/get', sort);
};
</script>

<template>
  <button class="toggle-button" @click="isCalendarView = !isCalendarView">
    {{ isCalendarView ? '一覧' : 'カレンダー' }}
  </button>
  <div class="reset-order" @click="resetSort()">
    {{ resetWord() }}
  </div>
  <Calendar v-if="isCalendarView" :houseworks="houseworks"></Calendar>
  <div v-else class="column list-body">
    <div class="row list-header">
      <div class="list-title" @click="sortOrder('title')">
        <span>家事</span>
        <SortIcon
          v-model:isAscending="isAscending.title"
          :label="'title'"
        ></SortIcon>
      </div>
      <div class="list-title" @click="sortOrder('comment')">
        <span>内容</span>
        <SortIcon
          v-model:isAscending="isAscending.comment"
          :label="'comment'"
        ></SortIcon>
      </div>
      <div class="list-title" @click="sortOrder('cycle_unit')">
        <span>実行周期</span>
        <SortIcon
          v-model:isAscending="isAscending.cycle_unit"
          :label="'cycle_unit'"
        ></SortIcon>
      </div>
      <div class="list-title" @click="sortOrder('next_date')">
        <span>次回実施日</span>
        <SortIcon
          v-model:isAscending="isAscending.next_date"
          :label="'next_date'"
        ></SortIcon>
      </div>
    </div>
    <HouseworkListItem
      v-for="item in houseworks"
      :key="item.id"
      :housework="item"
    ></HouseworkListItem>
  </div>
</template>
