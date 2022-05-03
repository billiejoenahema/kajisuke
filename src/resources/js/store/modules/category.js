import axios from 'axios';

const state = {
  data: [
    {
      id: null,
      name: '',
    },
  ],
  errors: [],
};

const getters = {
  data(state) {
    return state.data ?? [];
  },
  hasErrors(state) {
    return state.errors?.length > 0;
  },
  errors(state) {
    return state.errors ?? [];
  },
};

const actions = {
  async get({ commit }) {
    await axios
      .get('/api/categories')
      .then((res) => {
        console.log(res.status);
        commit('resetErrors');
        commit('setData', res.data.data);
      })
      .catch((err) => {
        console.log(err);
        commit('setErrors', err.message);
        commit('setData', {});
      });
  },
  async post({ commit }, data) {
    await axios
      .post('/api/categories', data)
      .then((res) => {
        console.log(res.status);
        commit('resetErrors');
      })
      .catch((err) => {
        console.log(err);
        commit('setErrors', err.message);
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
