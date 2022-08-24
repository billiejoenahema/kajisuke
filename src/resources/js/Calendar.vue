<script setup>
import { Qalendar } from 'qalendar';
import { reactive } from 'vue';

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
    :selected-date="new Date(2022, 0, 8)"
    :events="events"
    :config="config"
  />
</template>

<style>
/** Please observe,
    that your path to the node_modules directory might be different */
@import '../../node_modules/qalendar/dist/style.css';
</style>
