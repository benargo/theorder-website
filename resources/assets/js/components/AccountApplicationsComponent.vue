<template>
<form class="mt-5" v-if="applications.length > 0">
    <h2 class="h3">Applications</h2>
    <table class="table table-dark my-3">
        <thead>
            <tr>
                <th scope="col">Character Name</th>
                <th scope="col">Race</th>
                <th scope="col">Class</th>
                <th scope="col">Role</th>
                <th scope="col">Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr :class="classStatus(a.status)" v-for="a in applications">
                <td class="align-middle">{{ a.character_name }}</td>
                <td class="race-icons">
                    <img src="/images/raceicons_xs.png" :class="classIconRace(a.race_id)" :title="races[a.race_id].name" />
                    {{ races[a.race_id].name }}
                </td>
                <td class="class-icons">
                    <img src="/images/classicons_xs.png" :class="classIconClass(a.class_id)" :title="classes[a.class_id].name" />
                    {{ classes[a.class_id].name }}
                </td>
                <td class="align-middle">
                    {{ lang.labels[a.role] }}
                </td>
                <td class="align-middle">
                    {{ lang.status[a.status] }}
                    <span v-if="a.status === 'accepted'">
                        ({{ lang.on }}
                        {{ formatDate(a.accepted_at) }})
                    </span>
                    <span v-else-if="a.status === 'declined'">
                        ({{ lang.on }}
                        {{ formatDate(a.declined_at) }})
                    </span>
                    <span v-else-if="a.status === 'withdrawn'">
                        ({{ lang.on }}
                        {{ formatDate(a.withdrawn_at) }})
                    </span>
                </td>
                <td v-if="">
                    <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" :title="lang.labels.withdrawApplication" v-if="a.status === 'pending'" @click="withdrawApplication(a.id)">
                        <font-awesome-icon :icon="['fas', 'trash']" class="fa-sm"></font-awesome-icon>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</form>
</template>

<script>
export default {

    data: function() {
        return {
            applications: [],
        }
    },

    methods: {
        classIconClass: function(id) {
            return 'class-icon class-icon-xs class-icon-' + id
        },

        classIconRace: function(id) {
            return 'race-icon race-icon-xs race-icon-' + id
        },

        classStatus: function(status) {
            let classMapStatus = {
                accepted: 'table-success',
                declined: 'table-warning',
                pending: 'table-info',
                withdrawn: 'table-danger',
            }

            return classMapStatus[status]
        },

        formatDate: function(date) {
            return moment(date).format('D MMM YYYY')
        },

        langStatus: function(application) {
            return this.lang.status[application.status]
        },

        withdrawApplication: function(applicationId) {
            axios.patch('/api/applications/' + applicationId, {
                action: 'withdraw'
            }).then(function(response) {
                $('[data-toggle="tooltip"]').tooltip('hide')
                this.applications[applicationId].status = 'withdrawn'
            }.bind(this, applicationId))
        }

    },

    mounted: function() {
        axios.get('/api/user/applications')
            .then(function(response) {
                this.applications = response.data
            }.bind(this))
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
    },

    updated: function() {
        // Initialise tooltips...
        $('[data-toggle="tooltip"]').tooltip()
    },

}
</script>
