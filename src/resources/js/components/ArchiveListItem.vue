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
const onMouseover = () => {
  showTrashIcon.value = true;
};
const onMouseleave = () => {
  showTrashIcon.value = false;
};
const deleteArchive = async (id) => {
  if (!confirm('この履歴を削除しますか？')) return;
  await store.dispatch('archive/delete', id);
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
    <div>
      {{ archive.date ?? '履歴はまだありません' }}
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
