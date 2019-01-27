
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap')

window.Vue = require('vue')

import BootstrapVue from 'bootstrap-vue'
import FlagIcon from 'vue-flag-icon'
import { library as faLibrary } from '@fortawesome/fontawesome-svg-core'
import { faDiscord, faFacebook } from '@fortawesome/free-brands-svg-icons'
// import {  } from '@fortawesome/pro-light-svg-icons'
import {
    faAddressBook,
    faBalanceScale,
    faBell as faBellRegular,
    faCalendarAlt,
    faComments,
    faExternalLink,
    faHelmetBattle,
    faHistory,
    faNewspaper,
    faUserPlus as faUserPlusRegular
} from '@fortawesome/pro-regular-svg-icons'
import {
    faBell as faBellSolid,
    faCalendarEdit,
    faCalendarPlus,
    faChalkboard,
    faChartLine,
    faCheckCircle,
    faClipboardList,
    faHome,
    faPaperPlane,
    faPenFancy,
    faPencil,
    faTimesCircle,
    faUserClock,
    faUserPlus as faUserPlusSolid,
    faUsers,
    faUsersCog,
    faUsersCrown
} from '@fortawesome/pro-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

faLibrary.add(
    faAddressBook,
    faBalanceScale,
    faBellRegular,
    faBellSolid,
    faCalendarAlt,
    faCalendarEdit,
    faCalendarPlus,
    faChalkboard,
    faChartLine,
    faCheckCircle,
    faClipboardList,
    faComments,
    faDiscord,
    faExternalLink,
    faFacebook,
    faHelmetBattle,
    faHistory,
    faHome,
    faNewspaper,
    faPaperPlane,
    faPenFancy,
    faPencil,
    faTimesCircle,
    faUserClock,
    faUserPlusRegular,
    faUserPlusSolid,
    faUsers,
    faUsersCog,
    faUsersCrown,
)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use(BootstrapVue)
Vue.use(FlagIcon)
Vue.component('character-select-button', require('./components/CharacterSelectButton.vue'))
Vue.component('character-select-confirmation', require('./components/CharacterSelectConfirmation.vue'))
Vue.component('font-awesome-icon', FontAwesomeIcon)
Vue.component('notifications-menu-item', require('./components/NotificationsMenuItem.vue'))

const navbar = new Vue({
    el: '#navbar'
})
const app = new Vue({
    el: '#app'
})
