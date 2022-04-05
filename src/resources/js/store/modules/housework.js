import axios from 'axios';

const state = {
  data: [
    {
      id: null,
      user_id: 0,
      title: '',
      comment: '',
      cycle: '',
    },
  ],
  errors: [],
};

const getters = {
  data(state) {
    return state.data ?? [];
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
