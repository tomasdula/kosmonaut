// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue';
import App from './App';
import router from './router';
import Axios from 'Axios';
import BootstrapVue from 'bootstrap-vue';
import feather from 'vue-icon'

Vue.use(feather, 'v-icon')
Vue.use(BootstrapVue);

const axios = Axios.create();
axios.defaults.baseURL = 'http://cosmo.tode.cz/public/';

Vue.prototype.$http = axios;

Vue.config.productionTip = false;



/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  components: { App },
  template: '<App/>',
  
});

import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';