`
<script setup>
import { reactive, ref } from 'vue';
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
const isFocus = ref(false);
const isShowCheckIcon = ref(false);
const isShowRelatedHousework = ref(false);
const updateCategoryName = async () => {
  await store.dispatch('category/update', {
    id: category.id,
    name: category.name,
  });
  isShowCheckIcon = false;
  store.dispatch('category/get');
};
const debounceShowTooltip = useDebounce((bool) => showTooltip(bool));
const showTooltip = (bool) => {
  isShowRelatedHousework.value = bool;
};
</script>

<template>
  <li class="category-list-item">
    <input
      v-model="category.name"
      class="category-input"
      @focus.self="isFocus = true"
      @blur.self="isFocus = false"
      @mouseover="debounceShowTooltip(true)"
      @mouseleave="debounceShowTooltip(false)"
      @change="isShowCheckIcon = true"
    />
    <div
      class="check-icon-wrapper"
      v-if="category.name.length > 0 && isShowCheckIcon"
      @click="updateCategoryName()"
    >
      <font-awesome-icon
        class="check-icon"
        icon="check"
        title="カテゴリを更新"
      />
    </div>
    <div class="related-housework-list" v-if="isShowRelatedHousework">
      <div v-for="(housework, index) in category.houseworks" :key="index">
        {{ housework }}
      </div>
    </div>
  </li>
</template>
