<script setup>
import { computed } from 'vue';
import { VueDraggableNext as draggable } from 'vue-draggable-next';
import { useStore } from 'vuex';

defineProps({
  housework: {
    type: Object,
    required: true,
  },
});

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
      <div class="title">家事</div>
      <div class="schedule">----------- スケジュール -----------</div>
      <div class="next-date">実施予定日</div>
    </div>
    <draggable
      class="dragArea list-group w-full"
      group="housework"
      :list="houseworks"
      sort="true"
      @end="changeOrder()"
      v-model="houseworks"
    >
      <div
        class="list-group-item row"
        v-for="item in houseworks"
        :key="item.id"
      >
        <div class="column title">
          <div class="housework-title">
            <mark v-for="category in item.categories" :key="category.id">
              {{ category.name }}
            </mark>
          </div>
          <div>{{ item.title }}</div>
        </div>
        <div class="schedule">{{ item.comment }}</div>
        <div class="next">{{ item.next_date }}</div>
      </div>
    </draggable>
  </div>
</template>
