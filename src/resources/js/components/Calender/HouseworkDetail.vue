<script setup>
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import { computed, onMounted, reactive } from 'vue';
import { useStore } from 'vuex';
import ArchiveListItem from '../Archive/ArchiveListItem.vue';

const store = useStore();

const props = defineProps({
  id: {
    type: Number,
    required: true,
    default: null,
  },
  setIsShowEdit: Function,
  closeDialog: Function,
});
const housework = computed(() => store.getters['housework/item']);
const completedArchive = reactive({
  housework_id: props.id,
  date: null,
  content: '',
});
onMounted(async () => {
  await store.dispatch('housework/getItem', props.id);
  completedArchive.content = housework.value.comment;
});
const fetchData = () => {
  store.dispatch('housework/get');
};
const hasErrors = computed(() => store.getters['archive/hasErrors']);
const commitArchive = async () => {
  await store.dispatch('archive/post', completedArchive);
  if (hasErrors.value) return;
  await fetchData();
  props.closeDialog();
};
const deleteHousework = async () => {
  if (confirm('家事を削除しますか？')) {
    await store.dispatch('housework/delete', props.id);
  } else {
    return;
  }
  if (hasErrors.value) {
    return;
  }
  fetchData();
  closeDialog();
};
const onClick = () => {
  props.setIsShowEdit(true);
};
</script>

<template>
  <div class="event-dialog-content">
    <div class="modal-header">
      <div class="xmark-wrapper" @click="closeDialog()">
        <font-awesome-icon class="xmark" icon="xmark" @click="closeDialog()" />
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
      <archive-list-item
        v-if="housework.archives?.length"
        v-for="archive in housework.archives"
        :key="archive.id"
        :archive="archive"
      ></archive-list-item>
      <div v-else>履歴はまだありません</div>
    </div>
    <div class="store-button-area">
      <button class="edit-button" @click="onClick()">編集</button>
      <button class="edit-button delete-button" @click="deleteHousework()">
        削除
      </button>
      <Datepicker
        class="date-picker"
        v-model="completedArchive.date"
        autoApply
      ></Datepicker>
      <button class="store-button" @click="commitArchive()">完了</button>
    </div>
  </div>
</template>
