import { createStore } from 'vuex';

import auth from './modules/auth';
import housework from './modules/housework';
import profile from './modules/profile';

export const store = createStore({
  modules: {
    auth,
    housework,
    profile,
  },
});
