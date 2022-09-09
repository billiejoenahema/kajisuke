import axios from 'axios';

const state = {
  data: {},
  isLogin: false,
  errors: {},
};

const getters = {
  user(state) {
    return state.data.id > 0 ? state.data : {};
  },
  isLogin(state) {
    return state.data && state.data.id > 0;
  },
  invalidFeedback: (state) => (prop) => {
    return state.errors[prop] ?? '';
  },
  hasErrors(state) {
    return Object.keys(state.errors).length > 0;
  },
  birthDate(state) {
    const birth = state.data?.profile?.birth ?? '';
    const split = birth.split('-') ?? '';
    return {
      year: split[0] ?? '',
      month: split[1] ?? '',
      day: split[2] ?? '',
    };
  },
  profileImagePath: (state) => (image) => {
    return image ? `/storage/${image}` : '/storage/images/no_image.jpeg';
  },
};

const actions = {
  async get({ commit }) {
    await axios
      .get('/api/auth_user')
      .then((res) => {
        commit('setErrors', {});
        commit('setData', res.data.data);
      })
      .catch((err) => {
        commit('setErrors', err.message);
        commit('setData', {});
      });
  },
  async getIfNeeded({ dispatch, getters }) {
    if (getters.isLogin) return;
    await dispatch('get');
  },
  async update({ commit }, data) {
    await axios
      .patch('/api/profiles', data)
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
  async updateImage({ commit }, data) {
    const formData = new FormData();
    formData.append('image', data);
    await axios
      .post('/api/profile_image', formData)
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
