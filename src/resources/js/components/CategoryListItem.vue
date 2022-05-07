<script setup>
import { reactive, ref } from 'vue';
import { useStore } from 'vuex';

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
const isShowRelatedHousework = ref(false);
const updateCategoryName = () => {
  store.dispatch('category/update');
  console.log(category);
};
const setIsShowRelatedHouseworkItem = (bool) => {
  setTimeout(() => {
    isShowRelatedHousework.value = bool;
  }, 100);
};
</script>

<template>
  <li
    class="category-list-item"
    @mouseover="setIsShowRelatedHouseworkItem(true)"
    @mouseleave="setIsShowRelatedHouseworkItem(false)"
  >
    <input
      v-model="category.name"
      class="category-input"
      @focus.self="isFocus = true"
      @blur.self="isFocus = false"
    />
    <div
      class="check-icon-wrapper"
      v-if="category.name.length > 0 && isFocus"
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
