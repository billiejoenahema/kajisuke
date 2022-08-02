import axios from 'axios';

const state = {
  data: [],
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
  invalidFeedback: (state) => (prop) => {
    return state.errors[prop] ?? '';
  },
  hasErrors(state) {
    return Object.keys(state.errors).length > 0;
  },
};

const actions = {
  async get({ commit }, params) {
    await axios
      .get('/api/houseworks', { params })
      .then((res) => {
        commit('resetErrors');
        commit('setData', res.data.data);
      })
      .catch((err) => {
        commit('setErrors', err.response.data.errors);
        commit('setData', {});
      });
  },
  async getIfNeeded({ commit, dispatch }) {
    state.data.length === 0 && (await dispatch('get'));
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
  setItem(state, data) {
    state.item = {};
    state.item = data;
  },
  resetItem(state) {
    state.item = {};
    state.errors = {};
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
