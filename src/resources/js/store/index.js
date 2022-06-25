import { createStore } from 'vuex';

import auth from './modules/auth';
import archive from './modules/archive';
import category from './modules/category';
import housework from './modules/housework';
import houseworkOrder from './modules/houseworkOrder';
import profile from './modules/profile';
import toast from './modules/toast';

export const store = createStore({
  modules: {
    auth,
    archive,
    category,
    houseworkOrder,
    housework,
    profile,
    toast,
  },
});
