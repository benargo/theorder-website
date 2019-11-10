/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap')

window.Vue = require('vue')

import BootstrapVue from 'bootstrap-vue'
import draggable from 'vuedraggable'
import FlagIcon from 'vue-flag-icon'
import FullCalendar from '@fullcalendar/vue'
import bootstrapPlugin from '@fullcalendar/bootstrap'
import dayGridPlugin from '@fullcalendar/daygrid'
import listPlugin from '@fullcalendar/list'
import Prism from 'prismjs'
import VueApexCharts from 'vue-apexcharts'
const VueInputMask = require('vue-inputmask').default
window.kebabCase = require('dashify')
window.marked = require('marked')
window.moment = require('moment-timezone')
window.str_slug = require('./str_slug').default

/**
 * Second, import all of the Font Awesome libraries. There are thousands of
 * icons, but we only need to inport a few. So let's do that!
 */

import {
    library as faLibrary
} from '@fortawesome/fontawesome-svg-core'
import {
    faBattleNet as fabBattleNet,
    faDiscord as fabDiscord,
    faFacebook as fabFacebook,
    faPatreon as fabPatreon,
    faSafari as fabSafari,
} from '@fortawesome/free-brands-svg-icons'
// import {  } from '@fortawesome/pro-light-svg-icons'
import {
    faAddressBook as farAddressBook,
    faBalanceScale as farBalanceScale,
    faBell as farBell,
    faCalendar as farCalendar,
    faCalendarAlt as farCalendarAlt,
    faCalendarCheck as farCalendarCheck,
    faClock as farClock,
    faComments as farComments,
    faCopyright as farCopyright,
    faEnvelopeOpen as farEnvelopeOpen,
    faExternalLink as farExternalLink,
    faHelmetBattle as farHelmetBattle,
    faHistory as farHistory,
    faHome as farHome,
    faNewspaper as farNewspaper,
    faSearch as farSearch,
    faTimesCircle as farTimesCircle,
    faTrashAlt as farTrashAlt,
    faTreasureChest as farTreasureChest,
    faUserCog as farUserCog,
    faUserPlus as farUserPlus,
    faUserSecret as farUserSecret,
} from '@fortawesome/pro-regular-svg-icons'
import {
    faArrowDown as fasArrowDown,
    faArrowUp as fasArrowUp,
    faBell as fasBell,
    faCalendarEdit as fasCalendarEdit,
    faCalendarPlus as fasCalendarPlus,
    faChalkboard as fasChalkboard,
    faChartLine as fasChartLine,
    faCheck as fasCheck,
    faCheckCircle as fasCheckCircle,
    faChevronLeft as fasChevronLeft,
    faChevronRight as fasChevronRight,
    faClipboardList as fasClipboardList,
    faCogs as fasCogs,
    faConstruction as fasConstruction,
    faFirstAid as fasFirstAid,
    faHome as fasHome,
    faLayerPlus as fasLayerPlus,
    faMusicAlt as fasMusicAlt,
    faPaperPlane as fasPaperPlane,
    faPenFancy as fasPenFancy,
    faPencil as fasPencil,
    faSave as fasSave,
    faShield as fasShield,
    faSort as fasSort,
    faSword as fasSword,
    faTimes as fasTimes,
    faTimesCircle as fasTimesCircle,
    faTrash as fasTrash,
    faUserCog as fasUserCog,
    faUserClock as fasUserClock,
    faUserLock as fasUserLock,
    faUserPlus as fasUserPlus,
    faUsers as fasUsers,
    faUsersCog as fasUsersCog,
    faUsersCrown as fasUsersCrown,
} from '@fortawesome/pro-solid-svg-icons'
import {
    FontAwesomeIcon
} from '@fortawesome/vue-fontawesome'

faLibrary.add(
    // Brands
    fabBattleNet,
    fabDiscord,
    fabFacebook,
    fabPatreon,
    fabSafari,
    // Regular
    farAddressBook,
    farBalanceScale,
    farBell,
    farCalendar,
    farCalendarAlt,
    farCalendarCheck,
    farClock,
    farComments,
    farCopyright,
    farEnvelopeOpen,
    farExternalLink,
    farHelmetBattle,
    farHistory,
    farHome,
    farNewspaper,
    farSearch,
    farTimesCircle,
    farTrashAlt,
    farTreasureChest,
    farUserCog,
    farUserPlus,
    farUserSecret,
    // Solid
    fasArrowDown,
    fasArrowUp,
    fasBell,
    fasCalendarEdit,
    fasCalendarPlus,
    fasChalkboard,
    fasChartLine,
    fasCheck,
    fasCheckCircle,
    fasChevronLeft,
    fasChevronRight,
    fasClipboardList,
    fasCogs,
    fasConstruction,
    fasFirstAid,
    fasHome,
    fasLayerPlus,
    fasMusicAlt,
    fasPaperPlane,
    fasPenFancy,
    fasPencil,
    fasSave,
    fasShield,
    fasSort,
    fasSword,
    fasTimes,
    fasTimesCircle,
    fasTrash,
    fasUserCog,
    fasUserClock,
    fasUserLock,
    fasUserPlus,
    fasUsers,
    fasUsersCog,
    fasUsersCrown,
)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use(BootstrapVue)
Vue.use(FlagIcon)
Vue.use(FullCalendar)
Vue.use(dayGridPlugin)
Vue.use(listPlugin)
Vue.use(VueApexCharts)
Vue.use(VueInputMask)
Vue.component('account-settings', require('./components/AccountSettingsComponent.vue').default)
Vue.component('account-applications', require('./components/AccountApplicationsComponent.vue').default)
// Vue.component('api-clients', require('./components/APIClientsComponent.vue').default)
Vue.component('apex-chart', VueApexCharts)
Vue.component('applications-manager', require('./components/ApplicationsManagerComponent.vue').default)
Vue.component('character-select-button', require('./components/CharacterSelectButton.vue').default)
Vue.component('character-select-confirmation', require('./components/CharacterSelectConfirmation.vue').default)
Vue.component('draggable', draggable)
Vue.component('font-awesome-icon', FontAwesomeIcon)
Vue.component('guild-bank-viewer', require('./components/GuildBankViewerComponent.vue').default)
Vue.component('join-form', require('./components/NewApplicationComponent.vue').default)
Vue.component('manage-bankers', require('./components/ManageBankersComponent.vue').default)
Vue.component('marketplace', require('./components/MarketplaceComponent.vue').default)
Vue.component('new-rank', require('./components/NewRankComponent.vue').default)
Vue.component('news-item-editor', require('./components/NewsItemEditorComponent.vue').default)
Vue.component('news-item-manager', require('./components/NewsItemManagerComponent.vue').default)
Vue.component('notifications-menu-item', require('./components/NotificationsMenuItem.vue').default)
Vue.component('ranks-manager', require('./components/RanksManagerComponent.vue').default)
Vue.component('wow-icon', require('./components/WoWIconComponent.vue').default)

// Laravel Passport clients...
Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
)

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
)

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
)

const navbar = new Vue({
    el: '#navbar'
})

const app = new Vue({
    el: '#app',
    components: {
        FullCalendar,
    },
    data: {
        calendarPlugins: [
            bootstrapPlugin,
            dayGridPlugin,
            listPlugin,
        ],
    }
})

const footer = new Vue({
    el: '#footer'
})
