import { createStore } from 'vuex';

import auth from './modules/auth';
import category from './modules/category';
import housework from './modules/housework';
import profile from './modules/profile';

export const store = createStore({
  modules: {
    auth,
    category,
    housework,
    profile,
  },
});
