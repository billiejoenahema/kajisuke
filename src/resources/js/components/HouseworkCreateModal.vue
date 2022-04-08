<script setup>
import { computed, defineProps, reactive } from 'vue';
import { useStore } from 'vuex';

const store = useStore();

defineProps({
  closeModal: {
    type: Function,
    required: true,
  },
});

store.dispatch('category/get');

const categories = computed(() => store.getters['category/data']);
const housework = reactive({
  title: '',
  comment: '',
  cycle: '',
  category_id: 0,
});
const storeHousework = async () => {
  await store.dispatch('housework/post', housework);
  // 正常に保存されたらリセットする
  resetHousework();
};
const resetHousework = () => {
  housework.title = '';
  housework.comment = '';
  housework.cycle = '';
  housework.category_id = 0;
};
</script>

<template>
  <div class="modal" v-if="isModalOpen" @click.self="isModalOpen = false">
    <div class="housework-input-area">
      <input class="housework-title-input" v-model="housework.title" />
      <textarea v-model="housework.comment" rows="8"></textarea>
      <input class="housework-cycle" v-model="housework.cycle" />
      <select
        class="category-select"
        v-model="housework.category_id"
        name="category"
      >
        <option value="0">カテゴリを選択</option>
        <option
          v-for="category in categories"
          :key="category.id"
          :value="category.id"
          :selected="selected"
        >
          {{ category.name }}
        </option>
      </select>
      <div class="store-button-area">
        <button class="store-button" @click="storeHousework()">作成する</button>
      </div>
    </div>
  </div>
</template>
