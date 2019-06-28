import Vue from 'vue';
import Router from 'vue-router';

import Novy from '@/components/New';
import Kosmo from '@/components/Cosmo';

Vue.use(Router);

export default new Router({
  routes: [
    
    {
      path: '/novy',
      name: 'new',
      component: Novy
    },
    {
      path: '/',
      name: 'Kosmo',
      component: Kosmo
    }
    
  ]
});
