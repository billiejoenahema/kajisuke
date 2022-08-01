import axios from 'axios';

const state = {
  isLoading: false,
};

const getters = {
  isLoading(state) {
    return state.isLoading;
  },
};

const mutations = {
  setIsLoading(state, bool) {
    console.log('setIsLoading', bool);
    state.isLoading = bool;
  },
};

export default {
  namespaced: true,
  state,
  getters,
  mutations,
};
