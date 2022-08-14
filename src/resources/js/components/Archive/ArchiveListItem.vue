<script setup>
import { useStore } from 'vuex';

const store = useStore();
defineProps({
  archive: {
    id: 0,
    date: '',
  },
});
</script>

<template>
  <div class="archive-date">
    {{ archive.date }}
  </div>
</template>
