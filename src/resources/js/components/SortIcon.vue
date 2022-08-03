<script setup>
defineProps({
  isAscending: {
    type: Boolean,
    default: () => false,
  },
  label: '',
});
</script>

<template>
  <div class="sort-direction-icon-wrapper">
    <font-awesome-icon
      class="sort-direction-icon"
      :icon="isAscending === true ? 'sort-up' : 'sort-down'"
      :title="isAscending === true ? '昇順' : '降順'"
    />
  </div>
</template>

<style scoped>
.sort-direction-icon-wrapper {
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 0 8px;
}
</style>
