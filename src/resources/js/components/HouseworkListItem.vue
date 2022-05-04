<script setup>
import { ref } from 'vue';
import HouseworkEditModal from './HouseworkEditModal';

defineProps({
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
    cycleNumbers: Array,
  },
});
const isShowItemMenu = ref(false);
const isShowHouseworkModal = ref(false);
const showHouseworkModal = () => {
  isShowHouseworkModal.value = true;
};
const toggleShowItemMenu = () => {
  isShowItemMenu.value = !isShowItemMenu.value;
};
const closeModal = () => {
  isShowHouseworkModal.value = false;
};
const deleteHouseworkItem = () => {
  console.log(props.housework.id);
};
</script>

<template>
  <font-awesome-icon class="bars handle" icon="bars" />
  <div class="column title">
    <div class="housework-title">
      <mark>
        {{ housework.category?.name }}
      </mark>
    </div>
    <div>{{ housework.title }}</div>
  </div>
  <div class="schedule">{{ housework.comment }}</div>
  <div class="next">{{ housework.next_date }}</div>
  <div class="item-menu-icon" @click="toggleShowItemMenu()">
    <font-awesome-icon class="ellipsis-vertical" icon="ellipsis-vertical" />
    <div class="item-menu" v-if="isShowItemMenu">
      <ul>
        <li @click="showHouseworkModal()">編集</li>
        <li @click="deleteHouseworkItem()">削除</li>
      </ul>
    </div>
  </div>
  <HouseworkEditModal
    v-if="isShowHouseworkModal"
    :housework="housework"
    :closeModal="closeModal"
    :cycleNumbers="cycleNumbers"
  />
</template>
