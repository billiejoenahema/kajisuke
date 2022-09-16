<script setup>
import { ref, watchEffect } from 'vue';

const props = defineProps({
  character: {
    type: String,
    required: true,
    default: '',
  },
  maxLength: {
    type: Number,
    required: true,
    default: 0,
  },
  label: {
    type: String,
    required: false,
    default: 'Characters used',
  },
});

const className = ref('');
watchEffect(() => {
  const lengthRatio = props.character?.length / props.maxLength;
  if (lengthRatio >= 1) {
    className.value = 'full';
  } else if (lengthRatio > 0.8) {
    className.value = 'warning';
  } else {
    className.value = '';
  }
});
</script>

<template>
  <div class="characters-length" :class="className">
    <span class="label">{{ label }}</span
    >{{ character.length ?? 0 }}<span class="slash">/</span>{{ maxLength }}
  </div>
</template>

<style>
.characters-length {
  font-size: 0.5rem;
  display: flex;
  justify-content: flex-end;
}
.full {
  color: rgb(149, 149, 149);
}
.warning {
  color: orange;
}
.label {
  margin-right: 4px;
}
.label:after {
  content: ':';
}
.slash {
  margin: 0 4px;
}
</style>
