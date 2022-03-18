import { createStore } from 'vuex';
import auth from './modules/auth';
import houseworks from './modules/houseworks';

export const store = createStore({
  modules: {
    auth,
    houseworks,
  },
});
