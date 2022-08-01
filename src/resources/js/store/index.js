import { createStore } from 'vuex';

import auth from './modules/auth';
import archive from './modules/archive';
import category from './modules/category';
import consts from './modules/consts';
import housework from './modules/housework';
import loading from './modules/loading';
import user from './modules/user';
import toast from './modules/toast';

export const store = createStore({
  modules: {
    archive,
    auth,
    category,
    consts,
    housework,
    loading,
    toast,
    user,
  },
});
