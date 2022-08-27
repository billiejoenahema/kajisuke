import axios from 'axios';

const state = {
  data: {},
  errors: {},
};

const getters = {
  data(state) {
    return state.data ?? [];
  },
  genderValues(state) {
    return state.data.GENDER_VALUES ?? [];
  },
  prefectures(state) {
    return state.data.PREFECTURES ?? [];
  },
  years(state) {
    return state.data.YEARS ?? [];
  },
  months(state) {
    return state.data.MONTHS ?? [];
  },
  days(state) {
    return state.data.DAYS ?? [];
  },
  currentGender: (state) => (id) => {
    const gender = state.data.GENDER_VALUES?.find((v) => {
      return v.id == id;
    });
    return gender?.value ?? '';
  },
  currentPrefecture: (state) => (key) => {
    const prefecture = state.data.PREFECTURES?.find((v) => {
      return Object.keys(v)[0] == key;
    });
    return prefecture && Object.values(prefecture)[0];
  },
  maxLength: (state) => (key) => {
    const maxLength =
      state.data.MAX_LENGTHS?.find((v) => {
        return Object.keys(v)[0] == key;
      }) ?? {};
    return Object.values(maxLength)[0] ?? 0;
  },
  hasErrors(state) {
    return Object.keys(state.errors).length > 0;
  },
  errors(state) {
    return state.errors ?? {};
  },
};

const actions = {
  async get({ commit }) {
    await axios
      .get('/api/consts')
      .then((res) => {
        commit('setErrors', {});
        commit('setData', res.data);
      })
      .catch((err) => {
        commit('setErrors', err.message);
        commit('setData', {});
      });
  },
  async getIfNeeded({ dispatch, getters }) {
    if (getters.isLogin) return;
    await dispatch('get');
  },
};

const mutations = {
  setData(state, data) {
    state.data = data;
  },
  setErrors(state, data) {
    state.errors = {};
    state.errors = data;
  },
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations,
};
