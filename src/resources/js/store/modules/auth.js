import axios from 'axios';

const state = {
  errors: {},
};

const getters = {
  hasErrors(state) {
    return Object.keys(state.errors).length > 0;
  },
  invalidFeedback: (state) => (prop) => {
    return state.errors[prop] ?? '';
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
            commit('setErrors', {});
          })
          .catch((err) => {
            if (err.response.data.errors) {
              commit('setErrors', err.response.data.errors);
            } else {
              console.log('status', err.response.status);
              commit('setErrors', err.response.data.message);
              commit(
                'toast/setData',
                {
                  status: err.response.status,
                  content: err.response.data.message,
                },
                { root: true }
              );
            }
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
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations,
};
