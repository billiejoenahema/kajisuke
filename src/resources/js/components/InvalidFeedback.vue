<script setup>
defineProps({
  errors: {
    type: Array,
    default: () => [],
  },
});
</script>

<template>
  <div class="errors" v-if="errors">
    <div v-for="(error, index) in errors" :key="index">
      {{ error }}
    </div>
  </div>
</template>

<style scoped>
.errors {
  color: red;
  font-size: 0.8rem;
}
</style>
