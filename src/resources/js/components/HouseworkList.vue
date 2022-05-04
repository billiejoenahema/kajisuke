<script setup>
import { computed } from 'vue';
import { VueDraggableNext as draggable } from 'vue-draggable-next';
import { useStore } from 'vuex';
import HouseworkListItem from './HouseworkListItem';

const store = useStore();
const houseworks = computed(() => store.getters['housework/data']);
const cycleNumbers = [...Array(31).keys()].map((i) => ++i);

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
      <div class="title">家事</div>
      <div class="schedule">----------- スケジュール -----------</div>
      <div class="next-date">実施予定日</div>
      <div></div>
    </div>
    <draggable
      class="dragArea list-group w-full"
      group="housework"
      :list="houseworks"
      handle=".handle"
      @sort="changeOrder()"
      v-model="houseworks"
    >
      <div
        class="list-group-item row"
        v-for="item in houseworks"
        :key="item.id"
      >
        <HouseworkListItem :housework="item" :cycleNumber="cycleNumbers" />
      </div>
    </draggable>
  </div>
</template>
