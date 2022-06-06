import axios from 'axios';

const state = {
  data: [
    {
      id: null,
      title: '',
      comment: '',
      cycle: {
        num: '',
        unit: '',
      },
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
      .get('/api/houseworks')
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
      .post('/api/houseworks', data)
      .then((res) => {
        console.log(res.status);
        commit('resetErrors');
      })
      .catch((err) => {
        console.log(err);
        commit('setErrors', err.message);
      });
  },
  async update({ commit }, data) {
    await axios
      .patch(`/api/houseworks/${data.id}`, data)
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
