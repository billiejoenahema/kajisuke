import axios from 'axios';

const state = {
  profile: {
    id: null,
    name: '',
  },
  isLogin: false,
  errors: [],
};

const getters = {
  profile(state) {
    return state.profile.id ? profile : {};
  },
  isLogin(state) {
    return state.profile?.id !== null;
  },
  hasErrors(state) {
    return state.errors.length > 0 ?? false;
  },
  errors(state) {
    return state.errors ?? [];
  },
};

const actions = {
  async get({ commit }) {
    await axios
      .get('/api/profile')
      .then((res) => {
        commit('resetErrors');
        commit('setData', res.data.data);
      })
      .catch((err) => {
        console.log(err);
        commit('setErrors', err.message);
        commit('setData', {});
      });
  },
};

const mutations = {
  setData(state, data) {
    state.data = data;
  },
  setErrors(state, data) {
    state.errors = [];
    state.errors.push(data);
  },
  resetErrors(state) {
    state.errors = [];
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
