import { createStore } from 'vuex';
import auth from './modules/auth';
import houseworks from './modules/houseworks';
import profile from './modules/profile';

export const store = createStore({
  modules: {
    auth,
    houseworks,
    profile,
  },
});
