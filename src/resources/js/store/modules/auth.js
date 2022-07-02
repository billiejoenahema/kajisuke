import axios from 'axios';

const state = {
  errors: {},
};

const getters = {
  hasErrors(state) {
    return Object.keys(state.errors).length > 0;
  },
  errors(state) {
    return state.errors ?? {};
  },
};

const actions = {
  async login({ commit }, data) {
    await axios
      .get('http://localhost:8080/sanctum/csrf-cookie')
      .then(async (res) => {
        await axios
          .post('/login', data)
          .then((res) => {
            commit('resetErrors');
          })
          .catch((err) => {
            commit('setErrors', err.message);
          });
      });
  },
  async logout() {
    await axios.post('/logout');
  },
};

const mutations = {
  setErrors(state, data) {
    state.errors = {};
    state.errors = data;
  },
  resetErrors(state) {
    state.errors = {};
  },
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations,
};
