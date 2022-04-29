<script setup>
import { computed, onMounted, reactive, ref } from 'vue';
import { useStore } from 'vuex';
import { scrollToBottom } from '../utilities/scrollToBottom';

const store = useStore();

const props = defineProps({
  closeModal: {
    type: Function,
    required: true,
  },
});
onMounted(() => {
  scrollToBottom('category-list'); // prop: string
});
const category = reactive({
  name: '',
});
const categories = computed(() => store.getters['category/data']);
const storeCategory = async () => {
  await store.dispatch('category/post', category);
  await store.dispatch('category/get');
  scrollToBottom('category-list');
  category.name = '';
};
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
      <input v-model="category.name" />
      <div class="store-button-area">
        <button class="store-button" @click="storeCategory()">作成する</button>
      </div>
    </div>
  </div>
</template>
