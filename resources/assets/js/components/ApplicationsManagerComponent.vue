<template>
<div class="container">
    <div class="row my-5" v-if="items.length > 0">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h2 class="h3">Filters</h2>
                </div>
                <div class="card-body">
                    <form id="formFilters">
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="inputCharacterName">Character Name</label>
                                    <input type="text" class="form-control" id="inputCharacterName" maxlength="12" placeholder="Jaina" v-model="filters.characterName" @keyup="fetchItems(current_page)">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="inputRace">{{ lang.tableHeaders.race }}</label>
                                    <select class="form-control" id="inputRace" v-model.number="filters.raceId" @change="fetchItems(current_page)">
                                        <option value="">&nbsp;</option>
                                        <option :value="r.id" v-for="r in races">{{ r.name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="inputClass">Class</label>
                                    <select class="form-control" id="inputClass" v-model.number="filters.classId" @change="fetchItems(current_page)">
                                        <option value="">&nbsp;</option>
                                        <option :value="c.id" v-for="c in classes">{{ c.name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="inputRole">Role</label>
                                    <select class="form-control" id="inputRole" v-model="filters.role" @change="fetchItems(current_page)">
                                        <option value="">&nbsp;</option>
                                        <option value="damage">Damage</option>
                                        <option value="healer">Healer</option>
                                        <option value="tank">Tank</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="inputStatus">Status</label>
                                    <select class="form-control" id="inputStatus" v-model="filters.status" @change="fetchItems(current_page)">
                                        <option value=""></option>
                                        <option value="accepted">{{ lang.status.accepted }}</option>
                                        <option value="declined">{{ lang.status.declined }}</option>
                                        <option value="pending">{{ lang.status.pending }}</option>
                                        <option value="withdrawn">{{ lang.status.withdrawn }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row my-5" v-if="items.length > 0">
        <div class="col">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th scope="col">Character Name</th>
                        <th scope="col">Race</th>
                        <th scope="col">Class</th>
                        <th scope="col">Role</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(a,i) in items">
                        <th scope="row" class="align-middle">
                            {{ a.character_name }}
                        </th>
                        <td class="align-middle race-icons">
                            <img src="/images/raceicons_xs.png" :class="classIconRace(a.race_id)" :title="races[a.race_id].name" />
                            {{ races[a.race_id].name }}
                        </td>
                        <td class="align-middle class-icons">
                            <img src="/images/classicons_xs.png" :class="classIconClass(a.class_id)" :title="classes[a.class_id].name" />
                            {{ classes[a.class_id].name }}
                        </td>
                        <td class="align-middle">
                            {{ lang.roles[a.role] }}
                        </td>
                        <td class="align-middle" v-if="a.status == 'accepted'">
                            {{ lang.status[a.status] }}
                            ({{ lang.on + ' ' + formatDate(a.accepted_at) }})
                        </td>
                        <td class="align-middle" v-else-if="a.status == 'declined'">
                            {{ lang.status[a.status] }}
                            ({{ lang.on + ' ' + formatDate(a.declined_at) }})
                        </td>
                        <td class="align-middle" v-else-if="a.status == 'pending'">
                            {{ lang.status[a.status] }}
                            ({{ lang.since + ' ' + formatDate(a.created_at) }})
                        </td>
                        <td class="align-middle" v-else-if="a.status == 'withdrawn'">
                            {{ lang.status[a.status] }}
                            ({{ lang.on + ' ' + formatDate(a.withdrawn_at) }})
                        </td>
                        <td class="align-middle" v-if="a.status == 'pending'">
                            <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" :title="lang.buttons.accept" @click="decideApplication(a, 'accept')">
                                <font-awesome-icon :icon="['fas', 'check-circle']"></font-awesome-icon>
                                <span class="sr-only">{{ lang.buttons.accept }}</span>
                            </button>
                            <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" :title="lang.buttons.decline" @click="decideApplication(a, 'decline')">
                                <font-awesome-icon :icon="['fas', 'times-circle']"></font-awesome-icon>
                                <span class="sr-only">{{ lang.buttons.decline }}</span>
                            </button>
                        </td>
                        <td class="align-middle" v-else>
                            {{ lang.alerts.info_no_actions_available }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row my-5" v-else>
        <div class="col">
            <p class="lead text-center" v-if="this.hasFilters().length >= 1">{{ lang.alerts.info_applicant_count_zero_filtered }}</p>
            <p class="lead text-center" v-else>{{ lang.alerts.info_applicant_count_zero }}</p>
        </div>
    </div>
    <div class="row my-5" v-if="last_page > 1">
        <div class="col-12 text-center">
            <div class="btn-group">
                <button type="button" class="btn btn-primary btn-lg btn-pagination" @click="fetchItems(prev_page_url)" :disabled="(prev_page_url === null)">
                    &laquo; Previous
                </button>
                <button class="btn btn-primary btn-lg" :class="(page == current_page ? 'active' : '')" :aria-pressed="(page == current_page)" @click="fetchItems(page)" v-for="page in last_page">{{ page }}</button>
                <button type="button" class="btn btn-primary btn-lg btn-pagination" @click="fetchItems(next_page_url)" :disabled="(next_page_url === null)">
                    Next &raquo;
                </button>
            </div>
        </div>
    </div>
    <div class="row my-5" v-if="statistics">
        <div class="col">
            <h2 class="h3">Statistics</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col" colspan="2">Races</th>
                        <th scope="col" colspan="2">Classes</th>
                        <th scope="col" colspan="2">Roles</th>
                        <th scope="col" colspan="2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th class="race-icons" scope="row">
                            <img src="/images/raceicons_xs.png" :class="classIconRace(1)" title="Human" />
                            Human
                        </th>
                        <td>{{ statistics.races[1] ? statistics.races[1] : 0 }}</td>
                        <th class="class-icons" scope="row">
                            <img src="/images/classicons_xs.png" :class="classIconClass(11)" title="Druid" />
                            Druid
                        </th>
                        <td>{{ statistics.classes[11] ? statistics.classes[11] : 0 }}</td>
                        <th scope="row">Damage</th>
                        <td>{{ statistics.roles.damage ? statistics.roles.damage : 0 }}</td>
                        <th scope="row">Pending</th>
                        <td>{{ statistics.statuses.pending }}</td>
                    </tr>
                    <tr>
                        <th class="race-icons" scope="row">
                            <img src="/images/raceicons_xs.png" :class="classIconRace(3)" title="Dwarf" />
                            Dwarf
                        </th>
                        <td>{{ statistics.races[3] ? statistics.races[3] : 0 }}</td>
                        <th class="class-icons" scope="row">
                            <img src="/images/classicons_xs.png" :class="classIconClass(3)" title="Hunter" />
                            Hunter
                        </th>
                        <td>{{ statistics.classes[3] ? statistics.classes[3] : 0 }}</td>
                        <th scope="row">Healing</th>
                        <td>{{ statistics.roles.healing ? statistics.roles.healing : 0 }}</td>
                        <th scope="row">Accepted</th>
                        <td>{{ statistics.statuses.accepted }}</td>
                    </tr>
                    <tr>
                        <th class="race-icons" scope="row">
                            <img src="/images/raceicons_xs.png" :class="classIconRace(4)" title="Night Elf" />
                            Night Elf
                        </th>
                        <td>{{ statistics.races[4] ? statistics.races[4] : 0 }}</td>
                        <th class="class-icons" scope="row">
                            <img src="/images/classicons_xs.png" :class="classIconClass(8)" title="Mage" />
                            Mage
                        </th>
                        <td>{{ statistics.classes[8] ? statistics.classes[8] : 0 }}</td>
                        <th scope="row">Tank</th>
                        <td>{{ statistics.roles.tank ? statistics.roles.tank : 0 }}</td>
                        <th scope="row">Declined</th>
                        <td>{{ statistics.statuses.declined }}</td>
                    </tr>
                    <tr>
                        <th class="race-icons" scope="row">
                            <img src="/images/raceicons_xs.png" :class="classIconRace(7)" title="Gnome" />
                            Gnome
                        </th>
                        <td>{{ statistics.races[7] ? statistics.races[7] : 0 }}</td>
                        <th class="class-icons" scope="row">
                            <img src="/images/classicons_xs.png" :class="classIconClass(3)" title="Paladin" />
                            Paladin
                        </th>
                        <td>{{ statistics.classes[3] ? statistics.classes[3] : 0 }}</td>
                        <td colspan="2"></td>
                        <th scope="row">Withdrawn</th>
                        <td>{{ statistics.statuses.withdrawn }}</td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <th class="class-icons" scope="row">
                            <img src="/images/classicons_xs.png" :class="classIconClass(5)" title="Priest" />
                            Priest
                        </th>
                        <td>{{ statistics.classes[5] ? statistics.classes[5] : 0 }}</td>
                        <td colspan="4"></td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <th class="class-icons" scope="row">
                            <img src="/images/classicons_xs.png" :class="classIconClass(4)" title="Rogue" />
                            Rogue
                        </th>
                        <td>{{ statistics.classes[4] ? statistics.classes[4] : 0 }}</td>
                        <td colspan="4"></td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <th class="class-icons" scope="row">
                            <img src="/images/classicons_xs.png" :class="classIconClass(9)" title="Warlock" />
                            Warlock
                        </th>
                        <td>{{ statistics.classes[9] ? statistics.classes[9] : 0 }}</td>
                        <td colspan="4"></td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <th class="class-icons" scope="row">
                            <img src="/images/classicons_xs.png" :class="classIconClass(1)" title="Warrior" />
                            Warrior
                        </th>
                        <td>{{ statistics.classes[1] ? statistics.classes[1] : 0 }}</td>
                        <td colspan="4"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</template>

<script>
export default {
    data: function() {
        return {
            current_page: undefined,
            items: [],
            filters: undefined,
            first_page_url: undefined,
            from: undefined,
            last_page: undefined,
            last_page_url: undefined,
            next_page_url: undefined,
            per_page: 20,
            prev_page_url: undefined,
            statistics: {},
            to: undefined,
            total: 0,
        }
    },
    methods: {
        classIconClass: function(id) {
            return 'class-icon class-icon-xs class-icon-' + id
        },

        classIconRace: function(id) {
            return 'race-icon race-icon-xs race-icon-' + id
        },

        decideApplication: function(application, decision) {
            let states = {
                accept: 'accepted',
                decline: 'declined',
            }

            let newState = states[decision]

            axios.patch('/api/applications/' + application.id, {
                action: decision
            }).then(function(response) {
                $('[data-toggle="tooltip"]').tooltip('hide')

                application.accepted_at = moment()
                application.status = newState
            }.bind(this, application, newState))
        },

        fetchItems: function(page) {
            // If we passed a URL in here, strip it back to just the page
            // number...
            if (typeof page == 'string' && page.match(/^\/api\/applications\?page=/)) {
                page = page.match(/[\d]+$/).shift();
            }

            let path = '/api/applications'
            let queryString = this.hasFilters(this.filters)
            queryString['page'] = page

            axios.get(path, {
                params: queryString,
            }).then(function(response) {
                this.current_page = response.data.current_page
                this.items = Object.values(response.data.data)
                this.first_page_url = response.data.first_page_url
                this.from = response.data.from
                this.last_page = response.data.last_page
                this.last_page_url = response.data.last_page_url
                this.next_page_url = response.data.next_page_url
                this.path = response.data.path
                this.per_page = response.data.per_page
                this.prev_page_url = response.data.prev_page_url
                this.to = response.data.to
                this.total = response.data.total

                this.fetchStatistics()
            }.bind(this))
        },

        fetchStatistics: function () {
            let queryString = this.hasFilters(this.filters)

            axios.get('/api/applications/statistics', {
                params: queryString,
            }).then(function (response) {
                this.statistics = response.data
            }.bind(this))
        },

        formatDate: function(date) {
            return moment(date).format('D MMM YYYY')
        },

        hasFilters: function() {
            var filters = {}

            for (var i in this.filters) {
                if (this.filters[i] !== null && this.filters[i] !== undefined) {
                    filters[i] = this.filters[i]
                }
            }

            return filters
        },
    },
    mounted: function() {
        this.filters = this.startingFilters

        this.fetchItems(1)
    },
    props: {
        classes: {
            type: Object,
            required: true,
        },

        lang: {
            type: Object,
            required: true,
        },

        races: {
            type: Object,
            required: true,
        },

        startingFilters: {
            type: Object,
            default: function() {
                return {
                    characterName: undefined,
                    classId: undefined,
                    raceId: undefined,
                    role: undefined,
                    status: undefined,
                }
            },
        },
    },
    updated: function() {
        // Initialise tooltips...
        $('[data-toggle="tooltip"]').tooltip()
    },
}
</script>
