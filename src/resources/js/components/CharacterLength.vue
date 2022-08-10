<script setup>
import { ref, watchEffect } from 'vue';
import { CHARACTER_LENGTH_STATUS } from '../consts/characterLengthStatus';

const props = defineProps({
  character: {
    type: String,
    default: () => '',
  },
  maxLength: {
    type: Number,
    default: () => '',
  },
});

const className = ref('');
watchEffect(() => {
  const lengthRatio = props.character?.length / props.maxLength;
  if (lengthRatio === 1) {
    className.value = CHARACTER_LENGTH_STATUS.full;
  } else if (lengthRatio > 0.8) {
    className.value = CHARACTER_LENGTH_STATUS.warning;
  } else {
    className.value = CHARACTER_LENGTH_STATUS.blank;
  }
});
</script>

<template>
  <div class="characters-length" :class="className">
    Characters used: {{ character.length ?? 0 }} out of
    {{ maxLength }}
  </div>
</template>
