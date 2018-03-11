
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import BootstrapVue from 'bootstrap-vue';
import fontawesome from '@fortawesome/fontawesome';
import FontAwesomeIcon from '@fortawesome/vue-fontawesome';
import { faDiscord, faFacebook } from '@fortawesome/fontawesome-free-brands';
import { faBell as faBellRegular, faExternalLink, faHistory, } from '@fortawesome/fontawesome-pro-regular';
import { faBell as faBellSolid, faHome } from '@fortawesome/fontawesome-pro-solid';

fontawesome.library.add(faDiscord, faFacebook, faBellRegular, faExternalLink, faHistory, faBellSolid, faHome);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use(BootstrapVue);
// Vue.component('character-select-button', require('./components/CharacterSelectButton.vue'));
// Vue.component('character-select-confirmation', require('./components/CharacterSelectConfirmation.vue'));
Vue.component('font-awesome-icon', FontAwesomeIcon);

const navbar = new Vue({
    el: '#navbar'
});
const app = new Vue({
    el: '#app'
});
