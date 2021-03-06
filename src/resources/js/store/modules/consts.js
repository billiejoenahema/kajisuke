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
  defaultGender: (state) => (id) => {
    return state.data.GENDER_VALUES?.find((v) => {
      console.log(id);
      return v.id == id;
    });
  },
  prefectures(state) {
    return state.data.PREFECTURES ?? [];
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
        commit('resetErrors');
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
  resetErrors(state) {
    state.errors = {};
    state.hasErrors = false;
  },
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations,
};
