const state = {
  data: [],
  errors: [],
};

const getters = {
  data(state) {
    return data;
  },
  errors(state) {
    return state.errors;
  },
};

const actions = {
  async login({ commit }, param) {
    await axios
      .post('/api/login', param)
      .then((res) => {
        console.log(res);
        commit('resetErrors');
        commit('setData', res.data);
      })
      .catch((err) => {
        commit('setErrors', err.message);
      });
  },
};

const mutations = {
  setData(state, data) {
    state.data = data.data;
  },
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
