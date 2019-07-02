/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap')

window.Vue = require('vue')

import BootstrapVue from 'bootstrap-vue'
import FlagIcon from 'vue-flag-icon'
import Prism from 'prismjs'
const VueInputMask = require('vue-inputmask').default
window.marked = require('marked')
window.moment = require('moment-timezone')
window.str_slug = require('./str_slug').default
window.kebabCase = require('dashify')

/**
 * Second, import all of the Font Awesome libraries. There are thousands of
 * icons, but we only need to inport a few. So let's do that!
 */

import {
    library as faLibrary
} from '@fortawesome/fontawesome-svg-core'
import {
    faDiscord,
    faFacebook,
    faPatreon,
    faSafari,
} from '@fortawesome/free-brands-svg-icons'
// import {  } from '@fortawesome/pro-light-svg-icons'
import {
    faAddressBook,
    faBalanceScale,
    faBell as faBellRegular,
    faCalendar,
    faCalendarAlt,
    faCalendarCheck,
    faClock,
    faComments,
    faEnvelopeOpen,
    faExternalLink,
    faHelmetBattle,
    faHistory,
    faHome as faHomeRegular,
    faNewspaper,
    faTimesCircle as faTimesCircleRegular,
    faTrashAlt,
    faTreasureChest,
    faUserPlus as faUserPlusRegular
} from '@fortawesome/pro-regular-svg-icons'
import {
    faArrowDown,
    faArrowUp,
    faBell as faBellSolid,
    faCalendarEdit,
    faCalendarPlus,
    faChalkboard,
    faChartLine,
    faCheck,
    faCheckCircle,
    faChevronLeft,
    faChevronRight,
    faClipboardList,
    faFirstAid,
    faHome as faHomeSolid,
    faLayerPlus,
    faPaperPlane,
    faPenFancy,
    faPencil,
    faSave,
    faShield,
    faSword,
    faTimes,
    faTimesCircle as faTimesCircleSolid,
    faTrash,
    faUserCog,
    faUserClock,
    faUserPlus as faUserPlusSolid,
    faUsers,
    faUsersCog,
    faUsersCrown
} from '@fortawesome/pro-solid-svg-icons'
import {
    FontAwesomeIcon
} from '@fortawesome/vue-fontawesome'

faLibrary.add(
    faAddressBook,
    faArrowDown,
    faArrowUp,
    faBalanceScale,
    faBellRegular,
    faBellSolid,
    faCalendar,
    faCalendarAlt,
    faCalendarCheck,
    faCalendarEdit,
    faCalendarPlus,
    faChalkboard,
    faChartLine,
    faCheck,
    faCheckCircle,
    faChevronLeft,
    faChevronRight,
    faClipboardList,
    faClock,
    faComments,
    faDiscord,
    faEnvelopeOpen,
    faExternalLink,
    faFacebook,
    faFirstAid,
    faHelmetBattle,
    faHistory,
    faHomeRegular,
    faHomeSolid,
    faLayerPlus,
    faNewspaper,
    faPaperPlane,
    faPatreon,
    faPenFancy,
    faPencil,
    faSafari,
    faSave,
    faShield,
    faSword,
    faTimes,
    faTimesCircleRegular,
    faTimesCircleSolid,
    faTrash,
    faTrashAlt,
    faTreasureChest,
    faUserClock,
    faUserCog,
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
Vue.use(VueInputMask)
Vue.component('account-settings', require('./components/AccountSettingsComponent.vue').default)
Vue.component('account-applications', require('./components/AccountApplicationsComponent.vue').default)
Vue.component('api-clients', require('./components/APIClientsComponent.vue').default)
Vue.component('applications-manager', require('./components/ApplicationsManagerComponent.vue').default)
Vue.component('character-select-button', require('./components/CharacterSelectButton.vue').default)
Vue.component('character-select-confirmation', require('./components/CharacterSelectConfirmation.vue').default)
Vue.component('font-awesome-icon', FontAwesomeIcon)
Vue.component('join-form', require('./components/NewApplicationComponent.vue').default)
Vue.component('new-rank', require('./components/NewRankComponent.vue').default)
Vue.component('news-item-editor', require('./components/NewsItemEditorComponent.vue').default)
Vue.component('news-item-manager', require('./components/NewsItemManagerComponent.vue').default)
Vue.component('notifications-menu-item', require('./components/NotificationsMenuItem.vue').default)
Vue.component('ranks-manager', require('./components/RanksManagerComponent.vue').default)

const navbar = new Vue({
    el: '#navbar'
})

const app = new Vue({
    el: '#app'
})

const footer = new Vue({
    el: '#footer'
})
