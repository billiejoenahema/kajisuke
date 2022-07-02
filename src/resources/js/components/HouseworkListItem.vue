<script setup>
import { ref } from 'vue';
import { useStore } from 'vuex';
import HouseworkDetailModal from './HouseworkDetailModal';
import HouseworkEditModal from './HouseworkEditModal';

const store = useStore();
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
    category: {
      id: 0,
      name: '',
    },
  },
});
const isOverDate = () => {
  return props.housework.is_over_date ? 'is-over-date' : '';
};
const isShowItemMenu = ref(false);
const isShowEditModal = ref(false);
const isShowDetailModal = ref(false);
const showEditModal = () => {
  isShowEditModal.value = true;
};
const showDetailModal = () => {
  isShowDetailModal.value = true;
};
const toggleShowItemMenu = () => {
  isShowItemMenu.value = !isShowItemMenu.value;
};
const hideItemMenu = () => {
  isShowItemMenu.value = false;
};
const closeModal = () => {
  isShowEditModal.value = false;
  isShowDetailModal.value = false;
};
const deleteHouseworkItem = () => {
  console.log(props.housework.id);
};
</script>

<template>
  <div class="list-group-item row" @mouseleave="hideItemMenu()">
    <div class="bars-wrapper">
      <font-awesome-icon class="bars handle" icon="bars" />
    </div>
    <div class="column title" @click="showDetailModal()">
      <div class="category-name">
        <mark>
          {{ housework.category?.name }}
        </mark>
      </div>
      <div class="housework-title">{{ housework.title }}</div>
    </div>
    <div class="schedule">{{ housework.comment }}</div>
    <div class="cycle">{{ housework.cycle_value }}</div>
    <div class="next-date" :class="isOverDate()">
      {{ housework.next_date }}
    </div>
    <div class="item-menu-icon" @click="toggleShowItemMenu()">
      <font-awesome-icon class="ellipsis-vertical" icon="ellipsis-vertical" />
      <div class="item-menu" v-if="isShowItemMenu">
        <ul>
          <li @click="showEditModal()">編集</li>
          <li @click="deleteHouseworkItem()">削除</li>
        </ul>
      </div>
    </div>
    <HouseworkEditModal
      v-if="isShowEditModal"
      :id="housework.id"
      :closeModal="closeModal"
    />
    <HouseworkDetailModal
      v-if="isShowDetailModal"
      :housework="housework"
      :showEditModal="showEditModal"
      :closeModal="closeModal"
    />
  </div>
</template>
