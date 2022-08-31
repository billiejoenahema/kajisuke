<script setup>
import { computed, onMounted, reactive, ref } from 'vue';
import { useStore } from 'vuex';
import { scrollToBottom } from '../../utilities/scrollToBottom';
import CharacterLength from '../CharacterLength';
import CategoryListItem from './CategoryListItem';

const store = useStore();

defineProps({
  closeModal: Function,
});
onMounted(() => {
  scrollToBottom('category-list');
});
const newCategory = reactive({
  name: '',
});
const placeholder = ref('＋新しいカテゴリを作成');
const maxLength = computed(() => store.getters['consts/maxLength']);
const categories = computed(() => store.getters['category/data']);
const setIsLoading = (bool) => store.commit('loading/setIsLoading', bool);
const storeCategory = async () => {
  setIsLoading(true);
  await store.dispatch('category/post', newCategory);
  await store.dispatch('category/get');
  setIsLoading(false);
  scrollToBottom('category-list');
  newCategory.name = '';
  placeholder.value = '＋新しいカテゴリを作成';
};
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
        <category-list-item
          v-for="category in categories"
          :key="category.id"
          :category="category"
        ></category-list-item>
      </ul>
      <input
        class="category-input"
        v-model="newCategory.name"
        :max-length="maxLength('category_name')"
        :placeholder="placeholder"
        @focus="placeholder = ''"
        @blur="placeholder = '＋新しいカテゴリを作成'"
      />
      <character-length
        :character="newCategory.name"
        :max-length="maxLength('category_name') ?? 0"
      ></character-length>
      <div class="store-button-area">
        <button
          class="store-button"
          v-if="newCategory.name.length > 0"
          @click="storeCategory()"
        >
          作成する
        </button>
      </div>
    </div>
  </div>
</template>
