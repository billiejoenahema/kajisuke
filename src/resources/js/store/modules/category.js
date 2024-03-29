import axios from 'axios';

const state = {
  data: [],
  errors: {},
};

const getters = {
  data(state) {
    return state.data ?? [];
  },
  hasErrors(state) {
    return Object.keys(state.errors).length > 0;
  },
  invalidFeedback: (state) => (prop) => {
    return state.errors[prop] ?? '';
  },
};

const actions = {
  async get({ commit }) {
    await axios
      .get('/api/categories')
      .then((res) => {
        commit('setErrors', {});
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
  async post({ commit }, data) {
    await axios
      .post('/api/categories', data)
      .then((res) => {
        commit('setErrors', {});
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
      .patch(`/api/categories/${data.id}`, data)
      .then((res) => {
        commit('setErrors', {});
        commit(
          'toast/setData',
          { status: res.status, content: res.data.message },
          { root: true }
        );
      })
      .catch((err) => {
        let errors = {};
        Object.entries(err.response.data.errors).forEach(([k, v]) => {
          errors[`${k}_${data.index}`] = v;
        });
        console.log(errors);
        commit('setErrors', errors);
      });
  },
  async delete({ commit }, id) {
    await axios
      .delete(`/api/categories/${id}`)
      .then((res) => {
        commit('setErrors', {});
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
