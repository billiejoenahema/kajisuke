<script setup>
import { computed, reactive } from 'vue';
import { useStore } from 'vuex';

const store = useStore();

const props = defineProps({
  closeModal: {
    type: Function,
    required: true,
  },
});

const category = reactive({
  name: '',
});
const categories = computed(() => store.getters['category/data']);
const storeCategory = async () => {
  await store.dispatch('category/post', category);
  // 正常に保存されたらstateをリセットする
  resetCategory();
  props.closeModal();
  store.dispatch('category/get');
};
const resetCategory = () => {
  housework.title = '';
  housework.comment = '';
  housework.cycle_num = '';
  housework.cycle_unit = '';
  housework.category_id = 0;
};
</script>

<template>
  <div class="modal" @click.self="closeModal()">
    <div class="category-input-area">
      <ul>
        <li
          class="category-list"
          v-for="category in categories"
          :key="category.id"
        >
          {{ category.name }}
        </li>
      </ul>
      <input v-model="category.name" />
      <div class="store-button-area">
        <button class="store-button" @click="storeCategory()">作成する</button>
      </div>
    </div>
  </div>
</template>
