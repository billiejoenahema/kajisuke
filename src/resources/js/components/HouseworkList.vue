<script setup>
import { computed, ref } from 'vue';
import { VueDraggableNext as draggable } from 'vue-draggable-next';
import { useStore } from 'vuex';
import HouseworkEditModal from './HouseworkEditModal';

defineProps({
  housework: {
    type: Object,
    required: true,
  },
});

const store = useStore();
const isShowItemMenu = ref(false);
const isShowHouseworkModal = ref(false);
const houseworks = computed(() => store.getters['housework/data']);
const cycleNumbers = [...Array(31).keys()].map((i) => ++i);

const showHouseworkModal = () => {
  isShowHouseworkModal.value = true;
  isShowItemMenu.value = false;
};
const changeOrder = async () => {
  await store.dispatch('houseworkOrder/patch', newOrderIds(houseworks.value));
};
const newOrderIds = (houseworks) => {
  const ids = houseworks.map((item) => {
    return item.id;
  });
  return ids.join();
};
const showItemMenu = () => {
  isShowItemMenu.value = true;
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
        <font-awesome-icon class="bars handle" icon="bars" />
        <div class="column title">
          <div class="housework-title">
            <mark>
              {{ item.category?.name }}
            </mark>
          </div>
          <div>{{ item.title }}</div>
        </div>
        <div class="schedule">{{ item.comment }}</div>
        <div class="next">{{ item.next_date }}</div>
        <div class="item-menu-icon" @click="showItemMenu()">
          <font-awesome-icon
            class="ellipsis-vertical"
            icon="ellipsis-vertical"
          />
          <div class="item-menu" v-if="isShowItemMenu">
            <ul>
              <li @click="showHouseworkModal()">編集</li>
              <li>削除</li>
            </ul>
          </div>
        </div>
        <HouseworkEditModal
          v-if="isShowHouseworkModal"
          :housework="item"
          :closeModal="closeModal"
          :cycleNumbers="cycleNumbers"
        />
      </div>
    </draggable>
  </div>
</template>
