import axios from 'axios';

const state = {
  data: [
    {
      id: null,
      name: '',
    },
  ],
  errors: {},
};

const getters = {
  data(state) {
    return state.data ?? [];
  },
  hasErrors(state) {
    return Object.keys(state.errors).length > 0;
  },
  errors(state) {
    return state.errors ?? {};
  },
};

const actions = {
  async post({ commit }, data) {
    await axios
      .post('/api/archives', data)
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
        commit(
          'toast/setData',
          { status: err.response.status, content: err.response.data.message },
          { root: true }
        );
      });
  },
  async update({ commit }, data) {
    await axios
      .patch(`/api/archives/${data.id}`, data)
      .then((res) => {
        commit('setErrors', {});
        commit(
          'toast/setData',
          { status: res.response.status, content: res.data.message },
          { root: true }
        );
      })
      .catch((err) => {
        commit('setErrors', err.response.data.errors);
        commit(
          'toast/setData',
          { status: err.response.status, content: err.response.data.message },
          { root: true }
        );
      });
  },
  async delete({ commit }, id) {
    await axios
      .delete(`/api/archives/${id}`)
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
