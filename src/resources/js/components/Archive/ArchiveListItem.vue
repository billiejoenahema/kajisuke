<script setup>
import { computed, ref } from 'vue';
import { useStore } from 'vuex';

const store = useStore();
defineProps({
  archive: {
    id: 0,
    date: '',
  },
});
const showTrashIcon = ref(false);
const hasErrors = computed(() => store.getters['archive/hasErrors']);
const setIsLoading = (bool) => store.commit('loading/setIsLoading', bool);
const onMouseover = () => {
  showTrashIcon.value = true;
};
const onMouseleave = () => {
  showTrashIcon.value = false;
};
const deleteArchive = async (id) => {
  if (!confirm('この履歴を削除しますか？')) return;
  setIsLoading(true);
  await store.dispatch('archive/delete', id);
  setIsLoading(false);
  if (!hasErrors.value) {
    store.dispatch('housework/get');
  }
};
</script>

<template>
  <div
    class="archive-list-item row"
    @mouseover="onMouseover()"
    @mouseleave="onMouseleave()"
  >
    <div class="archive-date">
      {{ archive.date }}
    </div>
    <div
      class="trash-icon-wrapper"
      v-if="showTrashIcon"
      @click="deleteArchive(archive.id)"
    >
      <font-awesome-icon class="trash-icon" icon="trash" title="履歴を削除" />
    </div>
  </div>
</template>
