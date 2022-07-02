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
  item: {},
  errors: {},
};

const getters = {
  data(state) {
    return state.data ?? [];
  },
  item(state) {
    return state.item ?? {};
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
      .get('/api/houseworks')
      .then((res) => {
        commit('resetErrors');
        commit('setData', res.data.data);
      })
      .catch((err) => {
        commit('setErrors', err.response.data.errors);
        commit('setData', {});
      });
  },
  async getItem({ commit }, id) {
    await axios
      .get(`/api/houseworks/${id}`)
      .then((res) => {
        commit('resetErrors');
        commit('setItem', res.data.data);
      })
      .catch((err) => {
        commit('setErrors', err.response.data.errors);
        commit('setItem', {});
      });
  },
  async post({ commit }, data) {
    await axios
      .post('/api/houseworks', data)
      .then((res) => {
        commit('resetErrors');
        commit(
          'toast/setData',
          { status: res.status, content: res.data.message },
          { root: true }
        );
      })
      .catch((err) => {
        commit('setErrors', err.response.data.errors);
      });
  },
  async update({ commit }, data) {
    await axios
      .patch(`/api/houseworks/${data.id}`, data)
      .then((res) => {
        commit('resetErrors');
        commit(
          'toast/setData',
          { status: res.status, content: res.data.message },
          { root: true }
        );
      })
      .catch((err) => {
        commit('setErrors', err.response.data.errors);
      });
  },
  async delete({ commit }, id) {
    await axios
      .delete(`/api/houseworks/${id}`)
      .then((res) => {
        commit('resetErrors');
        commit(
          'toast/setData',
          { status: res.status, content: res.data.message },
          { root: true }
        );
      })
      .catch((err) => {
        commit('setErrors', err.response.data.errors);
      });
  },
};

const mutations = {
  setData(state, data) {
    state.data = data;
  },
  setItem(state, item) {
    state.item = {};
    state.item = item;
  },
  resetItem(state) {
    state.item = {};
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
