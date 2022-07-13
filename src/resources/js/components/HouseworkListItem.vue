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
    is_over_date: 0,
    category: {
      id: 0,
      name: '',
    },
  },
});
const isOverDate = () => {
  const isOverDate = props.housework.is_over_date;
  if (isOverDate < 0) {
    return 'is-over-date';
  } else if (isOverDate < 7) {
    return 'is-over-date-soon';
  } else {
    return '';
  }
};
const isShowEditModal = ref(false);
const isShowDetailModal = ref(false);
const showEditModal = () => {
  isShowEditModal.value = true;
};
const showDetailModal = () => {
  isShowDetailModal.value = true;
};
const closeModal = () => {
  isShowEditModal.value = false;
  isShowDetailModal.value = false;
};
</script>

<template>
  <div class="list-group-item row">
    <div class="column title" @click="showDetailModal()">
      <div class="category-name">
        <mark>
          {{ housework.category?.name }}
        </mark>
      </div>
      <div class="housework-title">{{ housework.title }}</div>
    </div>
    <div class="schedule" @click="showDetailModal()">
      {{ housework.comment }}
    </div>
    <div class="cycle" @click="showDetailModal()">
      {{ housework.cycle_value }}
    </div>
    <div class="next-date" :class="isOverDate()" @click="showDetailModal()">
      {{ housework.next_date }}
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
