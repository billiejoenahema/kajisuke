import { createStore } from 'vuex';

import auth from './modules/auth';
import profile from './modules/profile';

export const store = createStore({
  modules: {
    auth,
    profile,
  },
});
