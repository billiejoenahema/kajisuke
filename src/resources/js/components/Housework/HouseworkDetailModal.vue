<script setup>
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import { computed, reactive } from 'vue';
import { useStore } from 'vuex';
import ArchiveListItem from '../Archive/ArchiveListItem';

const store = useStore();

const props = defineProps({
  housework: {
    id: 0,
    user_id: 0,
    title: '',
    comment: '',
    cycle: {
      num: '',
      unit: '',
    },
    next_date: null,
    category: {
      id: 0,
      name: '',
    },
    archives: [
      {
        id: 0,
        housework_id: 0,
        date: '',
        content: '',
      },
    ],
  },
  showEditModal: Function,
  closeModal: Function,
});

const houseworkCommit = reactive({
  housework_id: props.housework.id,
  date: null,
  content: props.housework.comment,
});
const fetchData = async () => {
  await store.dispatch('housework/get');
  props.closeModal();
};
const hasErrors = computed(() => store.getters['archive/hasErrors']);
const editHousework = () => {
  props.closeModal();
  props.showEditModal();
};
const commitHousework = async () => {
  await store.dispatch('archive/post', houseworkCommit);
  if (!hasErrors.value) {
    fetchData();
  }
};
const deleteHousework = async () => {
  if (confirm('家事を削除しますか？')) {
    await store.dispatch('housework/delete', props.housework.id);
  } else {
    return;
  }
  if (hasErrors.value) {
    return;
  }
  fetchData();
};
</script>

<template>
  <div class="modal" @click.self="closeModal()">
    <div class="housework-detail-area">
      <div class="modal-header">
        <div class="xmark-wrapper" @click="closeModal()">
          <font-awesome-icon class="xmark" icon="xmark" />
        </div>
      </div>
      <label>家事名</label>
      <div class="show-housework-title">{{ housework.title }}</div>
      <label>詳細</label>
      <div class="show-housework-comment">{{ housework.comment }}</div>
      <label>次回予定日</label>
      <div class="show-housework-next-date">{{ housework.next_date }}</div>
      <label>履歴</label>
      <div class="show-housework-archives">
        <ArchiveListItem
          v-if="housework.archives.length"
          v-for="archive in housework.archives"
          :key="archive.id"
          :archive="archive"
        />
        <div v-else>履歴はまだありません</div>
      </div>
      <div class="store-button-area">
        <button class="edit-button" @click="editHousework()">編集</button>
        <button class="edit-button delete-button" @click="deleteHousework()">
          削除
        </button>
        <Datepicker
          class="date-picker"
          v-model="houseworkCommit.date"
          autoApply
        ></Datepicker>
        <button class="store-button" @click="commitHousework()">完了</button>
      </div>
    </div>
  </div>
</template>
