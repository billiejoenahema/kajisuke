<script setup>
import { reactive } from 'vue';
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
      <label>カテゴリ名</label>
      <input v-model="category.name" />
      <div class="store-button-area">
        <button class="store-button" @click="storeCategory()">作成する</button>
      </div>
    </div>
  </div>
</template>
