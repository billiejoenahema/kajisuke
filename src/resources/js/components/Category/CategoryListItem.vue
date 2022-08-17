<script setup>
import { computed, reactive, ref, watchEffect } from 'vue';
import { useStore } from 'vuex';
import { useDebounce } from '../../utilities/useDebounce';

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
const maxLength = computed(() => store.getters['consts/maxLength']);
const isShowTooltip = ref(false);
const showTrashIcon = ref(false);
const invalidStatus = ref('');
const inputRef = ref(null);
const canUpdate = ref(false);
const setIsLoading = (bool) => store.commit('loading/setIsLoading', bool);
watchEffect(() => {
  canUpdate.value =
    category.name !== props.category.name && category.name.length > 0;
});
const updateCategoryName = async () => {
  if (canUpdate.value) {
    await store.dispatch('category/update', {
      id: category.id,
      name: category.name,
    });
    store.dispatch('category/get');
  } else {
    category.name = props.category.name;
  }
};
const onBlur = () => {
  updateCategoryName();
  invalidStatus.value = '';
  showTrashIcon.value = false;
};
const onMouseover = () => {
  showTrashIcon.value = true;
  debounceShowTooltip(true);
};
const onMouseleave = () => {
  showTrashIcon.value = false;
  debounceShowTooltip(false);
};
const debounceShowTooltip = useDebounce((bool) => showTooltip(bool));
const showTooltip = (bool) => {
  isShowTooltip.value = bool;
};
const onChange = () => {
  if (category.name === props.category.name) {
    invalidStatus.value = '';
  } else {
    invalidStatus.value = canUpdate.value ? 'valid' : 'invalid';
  }
};
const onEnter = () => {
  inputRef.value.blur();
  debounceShowTooltip(false);
};
const deleteCategoryItem = async () => {
  if (!confirm('この履歴を削除しますか？')) return;
  setIsLoading(true);
  await store.dispatch('category/delete', category.id);
  setIsLoading(false);
  store.dispatch('category/get');
};
</script>

<template>
  <li
    class="category-list-item"
    @mouseover="onMouseover()"
    @mouseleave="onMouseleave()"
  >
    <input
      v-model="category.name"
      class="category-input"
      :class="invalidStatus"
      ref="inputRef"
      :maxlength="maxLength('category_name') ?? 0"
      @focus="showTrashIcon = true"
      @blur="onBlur()"
      @keyup="onChange()"
      @keyup.enter.prevent="onEnter()"
    />
    <div
      class="trash-icon-wrapper"
      v-if="showTrashIcon"
      @click="deleteCategoryItem()"
    >
      <font-awesome-icon
        class="trash-icon"
        icon="trash"
        title="カテゴリを削除"
      />
    </div>
    <div class="category-item-tooltip" v-show="isShowTooltip">
      <div
        v-if="category.houseworks.length"
        v-for="(housework, index) in category.houseworks"
        :key="index"
      >
        {{ housework }}
      </div>
      <div v-else>関連する家事はありません</div>
    </div>
  </li>
</template>
