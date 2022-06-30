const TIMEOUT = 4000;

const state = {
  data: {},
};

const getters = {
  data(state) {
    return state.data;
  },
  status(state) {
    if (state.data.status === undefined) return;
    if (state.data.status < 300) {
      return 'success';
    } else if (state.data.status >= 400) {
      return 'error';
    } else {
      return '';
    }
  },
};

const mutations = {
  setData(state, data) {
    state.data = data;
    setTimeout(() => {
      state.data = {};
    }, TIMEOUT);
  },
};

export default {
  namespaced: true,
  state,
  getters,
  mutations,
};
