<script setup>
import { computed, onMounted, reactive, ref, watchEffect } from 'vue';
import { useRouter } from 'vue-router';
import { useStore } from 'vuex';
import { MAX_LENGTH } from '../../consts/maxLength';
import { determineIsOver } from '../../utilities/determineIsOver';
import { scrollToBottom } from '../../utilities/scrollToBottom';
import CategoryListItem from './CategoryListItem';

const router = useRouter();
const store = useStore();

const props = defineProps({
  closeModal: Function,
});
onMounted(() => {
  scrollToBottom('category-list');
});
const newCategory = reactive({
  name: '',
});
const isOver = ref('');
const placeholder = ref('＋新しいカテゴリを作成');
const categories = computed(() => store.getters['category/data']);
const storeCategory = async () => {
  await store.dispatch('category/post', newCategory);
  await store.dispatch('category/get');
  scrollToBottom('category-list');
  newCategory.name = '';
  placeholder.value = '＋新しいカテゴリを作成';
};
watchEffect(() => {
  isOver.value = determineIsOver('categoryName', newCategory.name.length);
});
</script>

<template>
  <div class="modal" @click.self="closeModal()">
    <div class="category-input-area">
      <div class="modal-header">
        <div class="xmark-wrapper" @click="closeModal()">
          <font-awesome-icon class="xmark" icon="xmark" />
        </div>
      </div>
      <div>カテゴリ</div>
      <ul class="category-list" id="category-list">
        <CategoryListItem
          v-for="category in categories"
          :key="category.id"
          :category="category"
        />
      </ul>
      <input
        class="category-input"
        v-model="newCategory.name"
        :maxlength="MAX_LENGTH.categoryName"
        :placeholder="placeholder"
        @focus="placeholder = ''"
        @blur="placeholder = '＋新しいカテゴリを作成'"
      />
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
