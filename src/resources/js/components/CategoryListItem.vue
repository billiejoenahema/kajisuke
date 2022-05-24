`
<script setup>
import { reactive, ref, watchEffect } from 'vue';
import { useStore } from 'vuex';
import { useDebounce } from '../utilities/useDebounce';

const store = useStore();

const props = defineProps({
  category: {
    id: 0,
    name: '',
    houseworks: [],
  },
});
const category = reactive({
  id: props.category.id,
  name: props.category.name,
  houseworks: props.category.houseworks,
});
const isShowTooltip = ref(false);
const invalidStatus = ref('');
const canUpdate = ref(false);
watchEffect(() => {
  canUpdate.value =
    category.name !== props.category.name && category.name.length > 0;
});
const updateCategoryName = async () => {
  if (canUpdate.value) {
    await store.dispatch('category/update', {
      id: category.id,
      name: category.name,
    });
    store.dispatch('category/get');
  } else {
    category.name = props.category.name;
  }
};
const onBlur = () => {
  updateCategoryName();
  invalidStatus.value = '';
};
const debounceShowTooltip = useDebounce((bool) => showTooltip(bool));
const showTooltip = (bool) => {
  isShowTooltip.value = bool;
};
const onChange = () => {
  invalidStatus.value = canUpdate.value ? 'valid' : 'invalid';
};
</script>

<template>
  <li class="category-list-item">
    <input
      v-model="category.name"
      class="category-input"
      :class="invalidStatus"
      @mouseover="debounceShowTooltip(true)"
      @mouseleave="debounceShowTooltip(false)"
      @blur="onBlur()"
      @keyup="onChange()"
    />
    <div class="category-item-tooltip" v-if="isShowTooltip">
      <div v-for="(housework, index) in category.houseworks" :key="index">
        {{ housework }}
      </div>
    </div>
  </li>
</template>
