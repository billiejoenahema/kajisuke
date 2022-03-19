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
  async login({ commit }, data) {
    await axios
      .get('http://localhost:8000/sanctum/csrf-cookie', {
        withCredentials: true,
      })
      .then(async (res) => {
        console.log(res.status);
        await axios
          .post('/api/login', data)
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
