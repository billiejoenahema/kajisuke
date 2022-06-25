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
  async post({ commit }, data) {
    await axios
      .post('/api/archives', data)
      .then((res) => {
        commit('resetErrors');
        commit(
          'toast/setData',
          { type: 'success', content: res.data.message },
          { root: true }
        );
      })
      .catch((err) => {
        console.log('err');
        console.log(err);
        commit('setErrors', err.message);
        commit(
          'toast/setData',
          { type: 'error', content: err.message },
          { root: true }
        );
      });
  },
  async update({ commit }, data) {
    await axios
      .patch('/api/archives', data)
      .then((res) => {
        console.log(res.status);
        commit('resetErrors');
      })
      .catch((err) => {
        console.log(err);
        commit('setErrors', err.message);
      });
  },
  async delete({ commit }, id) {
    await axios
      .delete(`/api/archives/${id}`)
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
