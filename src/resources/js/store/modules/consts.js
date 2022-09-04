import axios from 'axios';

const state = {
  data: {},
  errors: {},
};

const getters = {
  data(state) {
    return state.data ?? [];
  },
  genderFormOptions(state) {
    return state.data?.GENDER ?? [];
  },
  genderTextValue: (state) => (id) => {
    const item = state.data.GENDER?.find((v) => {
      return v.id == id;
    });
    return item?.name ?? '';
  },
  prefectureFormOptions(state) {
    console.log(state.data.PREFECTURES ?? []);
    return state.data.PREFECTURES ?? [];
  },
  prefectureTextValue: (state) => (id) => {
    const item = state.data.PREFECTURES?.find((v) => {
      return v.id == id;
    });
    return item?.name ?? '';
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
  maxLength: (state) => (key) => {
    const maxLength =
      state.data.MAX_LENGTHS?.find((v) => {
        return Object.keys(v)[0] == key;
      }) ?? {};
    return Object.values(maxLength)[0] ?? 0;
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
