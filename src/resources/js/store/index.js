import { createStore } from 'vuex';

import auth from './modules/auth';
import archive from './modules/archive';
import category from './modules/category';
import housework from './modules/housework';
import user from './modules/user';
import toast from './modules/toast';

export const store = createStore({
  modules: {
    auth,
    user,
    archive,
    category,
    housework,
    toast,
  },
});
