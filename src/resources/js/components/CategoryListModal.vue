<script setup>
import { computed, onMounted, reactive, ref, watchEffect } from 'vue';
import { useStore } from 'vuex';
import { determineIsOver } from '../utilities/determineIsOver';
import { scrollToBottom } from '../utilities/scrollToBottom';

const store = useStore();

const props = defineProps({
  closeModal: Function,
});
onMounted(() => {
  scrollToBottom('category-list'); // prop: string
});
const newCategory = reactive({
  name: '',
});
const isOver = ref('');
const categories = computed(() => store.getters['category/data']);
const storeCategory = async () => {
  await store.dispatch('category/post', newCategory);
  await store.dispatch('category/get');
  props.closeModal();
  scrollToBottom('category-list');
  newCategory.name = '';
};
watchEffect(() => {
  isOver.value = determineIsOver('categoryName', newCategory.name.length);
});
</script>

<template>
  <div class="modal" @click.self="closeModal()">
    <div class="category-input-area">
      <ul class="category-list" id="category-list">
        <li
          class="category-list-item"
          v-for="category in categories"
          :key="category.id"
        >
          {{ category.name }}
        </li>
      </ul>
      <input v-model="newCategory.name" />
      <div class="store-button-area">
        <button
          class="store-button"
          v-if="newCategory.name.length > 0"
          :disabled="isOver === 'error'"
          @click="storeCategory()"
        >
          作成する
        </button>
        <div class="error-message" v-if="isOver === 'error'">
          文字数オーバー
        </div>
      </div>
    </div>
  </div>
</template>
