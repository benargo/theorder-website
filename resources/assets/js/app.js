
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import BootstrapVue from 'bootstrap-vue'
import { library as faLibrary } from '@fortawesome/fontawesome-svg-core'
import { faDiscord, faFacebook } from '@fortawesome/free-brands-svg-icons'
// import { faCheckCircle, faTimesCircle } from '@fortawesome/free-solid-svg-icons'
import { faBell as faBellRegular, faExternalLink, faHistory, } from '@fortawesome/pro-regular-svg-icons'
import { faBell as faBellSolid, faCheckCircle, faHome, faTimesCircle } from '@fortawesome/pro-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

faLibrary.add(
    faBellRegular,
    faBellSolid,
    faCheckCircle,
    faDiscord,
    faExternalLink,
    faFacebook,
    faHistory,
    faHome,
    faTimesCircle
)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use(BootstrapVue)
Vue.component('character-select-button', require('./components/CharacterSelectButton.vue'))
Vue.component('character-select-confirmation', require('./components/CharacterSelectConfirmation.vue'))
Vue.component('font-awesome-icon', FontAwesomeIcon)

const navbar = new Vue({
    el: '#navbar'
})
const app = new Vue({
    el: '#app'
})
