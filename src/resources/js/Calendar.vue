<script setup>
import { Qalendar } from 'qalendar';
import { computed, onMounted, reactive } from 'vue';
import { useStore } from 'vuex';
import { today } from './utilities/today';

const store = useStore();

const props = defineProps({
  houseworks: {
    type: String,
    required: true,
    default: () => {},
  },
});
const isLoading = computed(() => store.getters['loading/isLoading']);
const setData = () => {
  const event = props.houseworks?.map((e) => {
    const event = {
      title: e.title,
      with: '',
      time: {
        start: e.next_date,
        end: e.next_date,
      },
      color: color(e.date_diff),
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
    isEditable: false,
    id: null,
    description: '',
  },
]);

const color = (diff) => {
  if (diff < 0) {
    return 'red';
  } else if (0 < diff < 6) {
    return 'yellow';
  } else {
    ('green');
  }
};

const config = {
  locale: 'ja-JP',
  defaultMode: 'month',
  week: {
    startsOn: 'sunday',
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
  <Qalendar
    v-if="!isLoading"
    :selected-date="today()"
    :events="events"
    :config="config"
  />
</template>

<style>
@import '../../node_modules/qalendar/dist/style.css';
</style>
