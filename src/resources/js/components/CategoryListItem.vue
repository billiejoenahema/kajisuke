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
const canUpdate = ref(false);
const isShowTooltip = ref(false);
watchEffect(() => {
  canUpdate.value =
    category.name !== props.category.name && category.name.length > 0;
});
const updateCategoryName = async () => {
  canUpdate.value = false;
  await store.dispatch('category/update', {
    id: category.id,
    name: category.name,
  });
  store.dispatch('category/get');
};
const debounceShowTooltip = useDebounce((bool) => showTooltip(bool));
const showTooltip = (bool) => {
  isShowTooltip.value = bool;
};
</script>

<template>
  <li class="category-list-item">
    <input
      v-model="category.name"
      class="category-input"
      @mouseover="debounceShowTooltip(true)"
      @mouseleave="debounceShowTooltip(false)"
    />
    <div
      class="check-icon-wrapper"
      v-if="canUpdate"
      @click="updateCategoryName()"
    >
      <font-awesome-icon
        class="check-icon"
        icon="check"
        title="カテゴリを更新"
      />
    </div>
    <div class="category-item-tooltip" v-if="isShowTooltip">
      <div v-for="(housework, index) in category.houseworks" :key="index">
        {{ housework }}
      </div>
    </div>
  </li>
</template>
