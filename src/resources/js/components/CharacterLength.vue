<script setup>
defineProps({
  character: {
    type: String,
    default: () => '',
  },
  maxLength: {
    type: String,
    default: () => '',
  },
});
</script>

<template>
  <div class="characters-length">
    Characters used: {{ character.length ?? 0 }} out of
    {{ maxLength }}
  </div>
</template>
