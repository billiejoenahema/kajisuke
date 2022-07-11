import { createStore } from 'vuex';

import auth from './modules/auth';
import archive from './modules/archive';
import category from './modules/category';
import housework from './modules/housework';
import profile from './modules/profile';
import toast from './modules/toast';

export const store = createStore({
  modules: {
    auth,
    archive,
    category,
    housework,
    profile,
    toast,
  },
});
