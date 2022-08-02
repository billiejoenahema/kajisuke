<script setup>
import { computed, reactive } from 'vue';
import { useStore } from 'vuex';
import { SORT_COLUMNS } from '../../consts/sortColumns';
import SortIcon from '../SortIcon';
import HouseworkListItem from './HouseworkListItem';

const store = useStore();
const houseworks = computed(() => store.getters['housework/data']);
const sort = reactive({
  column: '',
  is_ascending: false,
});
const isAscending = reactive({
  title: false,
  comment: false,
  cycle_unit: false,
  next_date: true,
});
const initIsAscending = () => {
  isAscending.title = false;
  isAscending.comment = false;
  isAscending.cycle_unit = false;
  isAscending.next_date = true;
};
const resetWord = () => {
  return sort.column === '' ? '' : '並び順をリセット';
};
const resetSort = () => {
  sort.column = '';
  sort.is_ascending = false;
  initIsAscending();
  store.dispatch('housework/get');
};
const sortOrder = (value) => {
  if (value === sort.column) {
    sort.is_ascending = !sort.is_ascending;
  } else {
    sort.column = value;
    sort.is_ascending = true;
    initIsAscending();
  }
  isAscending[value] = sort.is_ascending;
  store.dispatch('housework/get', sort);
};
</script>

<template>
  <div class="reset-order" @click="resetSort()">
    {{ resetWord() }}
  </div>
  <div class="column list-body">
    <div class="row list-header">
      <div class="list-title" @click="sortOrder(SORT_COLUMNS.title)">
        <span>家事</span>
        <SortIcon
          v-model:isAscending="isAscending.title"
          :label="SORT_COLUMNS.title"
        />
      </div>
      <div class="list-title" @click="sortOrder(SORT_COLUMNS.comment)">
        <span>内容</span>
        <SortIcon
          v-model:isAscending="isAscending.comment"
          :label="SORT_COLUMNS.comment"
        />
      </div>
      <div class="list-title" @click="sortOrder(SORT_COLUMNS.cycle_unit)">
        <span>実行周期</span>
        <SortIcon
          v-model:isAscending="isAscending.cycle_unit"
          :label="SORT_COLUMNS.cycle_unit"
        />
      </div>
      <div class="list-title" @click="sortOrder(SORT_COLUMNS.next_date)">
        <span>次回実施日</span>
        <SortIcon
          v-model:isAscending="isAscending.next_date"
          :label="SORT_COLUMNS.next_date"
        />
      </div>
    </div>
    <HouseworkListItem
      v-for="item in houseworks"
      :key="item.id"
      :housework="item"
    />
  </div>
</template>
