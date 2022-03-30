import axios from 'axios';

const state = {
  errors: [],
};

const getters = {
  hasErrors(state) {
    return state.errors.length > 0 ?? false;
  },
  errors(state) {
    return state.errors ?? [];
  },
};

const actions = {
  async login({ commit }, data) {
    await axios
      .get('http://localhost:8080/sanctum/csrf-cookie')
      .then(async (res) => {
        console.log(res.status);
        await axios
          .post('/login', data)
          .then((res) => {
            console.log(res.status);
            commit('resetErrors');
          })
          .catch((err) => {
            console.log(err.message);
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
    state.errors = [];
    state.errors.push(data);
  },
  resetErrors(state) {
    state.errors = [];
  },
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations,
};
