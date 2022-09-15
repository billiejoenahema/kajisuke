<script setup>
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import { computed, onUnmounted, ref } from 'vue';
import { useStore } from 'vuex';
import { CYCLE_UNIT } from '../../consts/cycle_unit';
import { ONE_MONTH } from '../../consts/oneMonthDateList';
import CharacterLength from '../CharacterLength';
import InvalidFeedback from '../InvalidFeedback';

const props = defineProps({
  id: {
    type: Number,
    required: true,
    default: null,
  },
  setIsShowEdit: Function,
  closeDialog: Function,
});

const store = useStore();
store.dispatch('housework/getItem', props.id);
onUnmounted(() => {
  store.commit('housework/resetItem');
});
const editable = ref([]);
const onEditable = (index) => {
  editable.value = [];
  editable.value[index] = true;
};

const setIsLoading = (bool) => store.commit('loading/setIsLoading', bool);
const housework = computed(() => store.getters['housework/item']);
const categories = computed(() => store.getters['category/data']);
const maxLength = computed(() => store.getters['consts/maxLength']);
const hasErrors = computed(() => store.getters['housework/hasErrors']);
const invalidFeedback = computed(
  () => store.getters['housework/invalidFeedback']
);

const updateHousework = async () => {
  setIsLoading(true);
  await store.dispatch('housework/update', housework.value);
  setIsLoading(false);
  if (hasErrors.value) return;
  await store.dispatch('housework/get');
  props.setIsShowEdit(false);
};
const updateArchive = async (archive) => {
  if (!confirm('この履歴を更新しますか？')) return;
  setIsLoading(true);
  await store.dispatch('archive/update', archive);
  setIsLoading(false);
  if (hasErrors.value) return;
  editable.value = [];
  store.dispatch('housework/getItem', props.housework.id);
};
const deleteArchive = async (id) => {
  if (!confirm('この履歴を削除しますか？')) return;
  setIsLoading(true);
  await store.dispatch('archive/delete', id);
  setIsLoading(false);
  if (!hasErrors.value) {
    store.dispatch('housework/getItem', props.housework.id);
  }
};
</script>

<template>
  <div class="event-dialog-content">
    <div class="modal-header">
      <div class="xmark-wrapper" @click="closeDialog()">
        <font-awesome-icon class="xmark" icon="xmark" />
      </div>
    </div>
    <label>家事名</label>
    <input
      class="housework-title-input"
      :class="invalidFeedback('title') && 'invalid'"
      v-model="housework.title"
      :max-length="maxLength('housework_title')"
    />
    <InvalidFeedback :errors="invalidFeedback('title')"></InvalidFeedback>
    <CharacterLength
      :character="housework.title"
      :max-length="maxLength('housework_title') ?? 0"
    ></CharacterLength>
    <label>詳細</label>
    <textarea
      :class="invalidFeedback('comment') && 'invalid'"
      v-model="housework.comment"
      rows="6"
    ></textarea>
    <InvalidFeedback :errors="invalidFeedback('comment')"></InvalidFeedback>
    <CharacterLength
      :character="housework.comment"
      :max-length="maxLength('housework_comment') ?? 0"
    ></CharacterLength>
    <div class="column">
      <label>実行周期</label>
      <div class="housework-cycle">
        <select v-model="housework.cycle_num">
          <option v-for="day in ONE_MONTH.date_list" :key="day" :value="day">
            {{ day }}
          </option>
        </select>
        <select v-model="housework.cycle_unit">
          <option
            v-for="item in CYCLE_UNIT"
            :value="item.cycle_unit_id"
            :selected="item.cycle_unit_id == housework.cycle_unit"
          >
            {{ item.content }}
          </option>
        </select>
        <span> に一度</span>
      </div>
    </div>
    <label>次回実施日</label>
    <Datepicker
      class="date-picker"
      :class="invalidFeedback('next_date') && 'invalid'"
      v-model="housework.next_date"
      format="yyyy/MM/dd"
      autoApply
    ></Datepicker>
    <label>カテゴリ</label>
    <select
      class="category-select"
      :class="invalidFeedback('category_id') && 'invalid'"
      v-model="housework.category_id"
      name="category"
    >
      <option
        v-for="category in categories"
        :key="category.id"
        :value="category.id"
        :selected="category.id === housework.category_id"
      >
        {{ category.name }}
      </option>
    </select>
    <label>履歴</label>
    <div class="show-housework-archives">
      <div
        v-if="housework.archives?.length"
        v-for="(archive, index) in housework.archives"
        :key="archive.id"
        class="archive-list-item"
      >
        <div class="archive-date-edit row" v-if="editable[index]">
          <input type="text" v-model="archive.date" />
          <div class="archive-icons-wrapper row">
            <font-awesome-icon
              class="circle-check-icon"
              icon="circle-check"
              title="履歴を更新"
              @click="updateArchive(archive)"
            />
            <font-awesome-icon
              class="trash-icon"
              icon="trash"
              title="履歴を削除"
              @click="deleteArchive(archive.id)"
            />
          </div>
        </div>
        <div class="archive-date" v-else @click="onEditable(index)">
          {{ archive.date }}
        </div>
      </div>
      <div v-else>履歴はまだありません</div>
    </div>
    <div class="store-button-area">
      <button class="store-button" @click="updateHousework()">更新</button>
      <button class="cancel-button" @click="setIsShowEdit(false)">
        キャンセル
      </button>
    </div>
  </div>
</template>
