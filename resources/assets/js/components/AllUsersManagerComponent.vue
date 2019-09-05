<template>
<div>
    <!-- <div class="row" v-if="items.length > 0">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h2 class="h3">{{ lang.filters }}</h2>
                </div>
                <div class="card-body">
                    <form id="formFilters">
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="inputCharacterName">{{ lang.tableHeaders.characterName }}</label>
                                    <input type="text" class="form-control" id="inputCharacterName" maxlength="12" placeholder="Jaina" v-model="filters.characterName" @keyup="fetchItems(current_page)">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="inputRace">{{ lang.tableHeaders.race }}</label>
                                    <select class="form-control" id="inputRace" v-model.number="filters.raceId" @change="fetchItems(current_page)">
                                        <option value="">&nbsp;</option>
                                        <option :value="id" v-for="(race,id) in lang.races">{{ race }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="inputClass">{{ lang.tableHeaders.class }}</label>
                                    <select class="form-control" id="inputClass" v-model.number="filters.classId" @change="fetchItems(current_page)">
                                        <option value="">&nbsp;</option>
                                        <option :value="id" v-for="(c,id) in lang.classes">{{ c }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="inputRole">{{ lang.tableHeaders.role }}</label>
                                    <select class="form-control" id="inputRole" v-model="filters.role" @change="fetchItems(current_page)">
                                        <option value="">&nbsp;</option>
                                        <option value="damage">{{ lang.roles.damage }}</option>
                                        <option value="healer">{{ lang.roles.healer }}</option>
                                        <option value="tank">{{ lang.roles.tank }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="inputStatus">{{ lang.tableHeaders.status }}</label>
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
    <div class="row" v-if="items.length > 0">
        <div class="col">
            <table class="table my-4">
                <thead>
                    <tr>
                        <th scope="col">{{ lang.tableHeaders.characterName }}</th>
                        <th scope="col">{{ lang.tableHeaders.race }}</th>
                        <th scope="col">{{ lang.tableHeaders.class }}</th>
                        <th scope="col">{{ lang.tableHeaders.role }}</th>
                        <th scope="col">{{ lang.tableHeaders.status }}</th>
                        <th scope="col">{{ lang.tableHeaders.actions }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(a,i) in items">
                        <th scope="row" class="align-middle">
                            {{ a.character_name }}
                        </th>
                        <td class="align-middle race-icons">
                            <img src="/images/raceicons_xs.png" :class="classIconRace(a.race_id)" :title="lang.races[a.race_id]" />
                            {{ lang.races[a.race_id] }}
                        </td>
                        <td class="align-middle class-icons">
                            <img src="/images/classicons_xs.png" :class="classIconClass(a.class_id)" :title="lang.classes[a.class_id]" />
                            {{ lang.classes[a.class_id] }}
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
    <div class="row mt-5" v-else>
        <div class="col">
            <p class="lead text-center" v-if="this.hasFilters().length >= 1">{{ lang.alerts.info_applicant_count_zero_filtered }}</p>
            <p class="lead text-center" v-else>{{ lang.alerts.info_applicant_count_zero }}</p>
        </div>
    </div>
    <div class="row" v-if="last_page > 1">
        <div class="col-12 text-center">
            <div class="btn-group">
                <button type="button" class="btn btn-primary btn-lg btn-pagination" @click="fetchItems(prev_page_url)" :disabled="(prev_page_url === null)">
                    {{ lang.buttons.previous }}
                </button>
                <button class="btn btn-primary btn-lg" :class="(page == current_page ? 'active' : '')" :aria-pressed="(page == current_page)" @click="fetchItems(page)" v-for="page in last_page">{{ page }}</button>
                <button type="button" class="btn btn-primary btn-lg btn-pagination" @click="fetchItems(next_page_url)" :disabled="(next_page_url === null)">
                    {{ lang.buttons.next }}
                </button>
            </div>
        </div>
    </div> -->
</div>
</template>

<script>
export default {
    computed: {

    },
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
            let path = '/api/applications'
            let queryString = this.hasFilters(this.filters)
            queryString['page'] = page

            axios.get(path, {
                params: queryString,
            }).then(function(response) {
                this.current_page = response.data.current_page
                this.items = response.data.data
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
        lang: {
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
