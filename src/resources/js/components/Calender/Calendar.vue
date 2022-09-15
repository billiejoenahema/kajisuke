<script setup>
import { Qalendar } from 'qalendar';
import { computed, onMounted, reactive, ref } from 'vue';
import { useStore } from 'vuex';
import { today } from '../../utilities/today';
import HouseworkDetail from './HouseworkDetail.vue';
import HouseworkEdit from './HouseworkEdit.vue';

const store = useStore();

const houseworks = computed(() => store.getters['housework/data']);
const setData = () => {
  const event = houseworks.value.map((e) => {
    const event = {
      title: e.title,
      with: '',
      time: {
        start: e.next_date,
        end: e.next_date,
      },
      color: getColor(e.date_diff),
      id: e.id,
      description: e.comment,
    };
    return { ...event };
  });
  Object.assign(events, event);
};

onMounted(() => {
  setData();
});

const events = reactive([
  {
    title: '',
    with: '',
    time: {
      start: '',
      end: '',
    },
    color: '',
    isCustom: true,
    isEditable: true,
    id: null,
    description: '',
    comment: '',
    next_date: '',
    archives: [],
  },
]);

const getColor = (diff) => {
  if (diff < 0) {
    return 'red';
  } else if (diff < 6) {
    return 'yellow';
  } else {
    return 'green';
  }
};
const isShowEdit = ref(false);
const setIsShowEdit = (bool) => {
  isShowEdit.value = bool;
};

const config = {
  locale: 'ja-JP',
  defaultMode: 'month',
  week: {
    startsOn: 'sunday',
  },
  eventDialog: {
    isCustom: true,
  },
  style: {
    colorSchemes: {
      meetings: {
        color: '#fff',
        backgroundColor: '#131313',
      },
      sports: {
        color: '#fff',
        backgroundColor: '#ff4081',
      },
    },
  },
};
</script>

<template>
  <Qalendar :selected-date="today()" :events="events" :config="config">
    <template #eventDialog="props">
      <div
        v-if="props.eventDialogData && props.eventDialogData.title"
        class="event-dialog"
      >
        <HouseworkDetail
          v-show="!isShowEdit"
          :id="props.eventDialogData.id"
          :close-dialog="props.closeEventDialog"
          :set-is-show-edit="setIsShowEdit"
        ></HouseworkDetail>
        <HouseworkEdit
          v-show="isShowEdit"
          :id="props.eventDialogData.id"
          :close-dialog="props.closeEventDialog"
          :set-is-show-edit="setIsShowEdit"
        ></HouseworkEdit>
      </div>
    </template>
  </Qalendar>
</template>

<style>
@import '../../../../node_modules/qalendar/dist/style.css';
</style>
