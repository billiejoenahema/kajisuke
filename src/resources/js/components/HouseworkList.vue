<script setup>
import { computed } from 'vue';
import { VueDraggableNext as draggable } from 'vue-draggable-next';
import { useStore } from 'vuex';
import HouseworkListItem from './HouseworkListItem';

const store = useStore();
const houseworks = computed(() => store.getters['housework/data']);

const changeOrder = async () => {
  await store.dispatch('houseworkOrder/patch', newOrderIds(houseworks.value));
};
const newOrderIds = (houseworks) => {
  const ids = houseworks.map((item) => {
    return item.id;
  });
  return ids.join();
};
</script>

<template>
  <div class="column list-body">
    <div class="row list-header">
      <div></div>
      <div class="title-header">家事</div>
      <div class="schedule-header">----------- スケジュール -----------</div>
      <div class="cycle-value-header">実行周期</div>
      <div class="next-date-header" :class="isOverDate">次回予定日</div>
      <div></div>
    </div>
    <draggable
      class="dragArea list-group w-full"
      handle=".handle"
      @sort="changeOrder()"
      v-model="houseworks"
    >
      <HouseworkListItem
        v-for="item in houseworks"
        :key="item.id"
        :housework="item"
      />
    </draggable>
  </div>
</template>
