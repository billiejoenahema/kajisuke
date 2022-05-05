<script setup>
import { reactive, ref } from 'vue';
import { useStore } from 'vuex';

const store = useStore();

const props = defineProps({
  category: {
    id: 0,
    name: '',
  },
});
const category = reactive({
  id: props.category.id,
  name: props.category.name,
});
const isFocus = ref(false);
const updateCategoryName = () => {
  store.dispatch('category/update');
  console.log(category);
};
</script>

<template>
  <li class="category-list-item">
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
  </li>
</template>
