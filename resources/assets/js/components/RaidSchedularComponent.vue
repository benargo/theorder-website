<template>
<div class="container">
    <div class="row">
        <div class="col text-md-right">
            <button class="btn btn-primary btn-lg btn-block-xs-only" v-b-modal.modalNewRaidSchedule>
                <font-awesome-icon :icon="['fas', 'calendar-plus']"></font-awesome-icon>
                <span class="ml-3">Schedule new raid</span>
            </button>
        </div>
    </div>
    <b-modal id="modalNewRaidSchedule" ref="modalNewRaidSchedule" size="lg" title="New Raid" busy>
        <form class="needs-validation" ref="formNewRaidSchedule" id="formNewRaidSchedule">
            <div class="form-group row">
                <label for="inputStartTime" class="col-sm-3 col-form-label">
                    Start Date
                    <small id="startHelpBlock" class="form-text text-muted">
                        Select the first date and time a raid from this schedule will run.
                    </small>
                </label>
                <div class="col-sm-9">
                    <datetime-picker v-model="new_schedule.start" color="#f8b700" format="YYYY-MM-DD HH:mm" formatted="DD/MM/YYYY HH:mm" :first-day-of-week="1" :minute-interval="5" id="inputStart" required no-label dark />
                </div>
            </div>
            <div class="form-group row">
                <label for="inputRepeat" class="col-sm-3 col-form-label">
                    Repeat

                </label>
                <div class="col-sm-9 form-inline">
                    Repeat this schedule every
                    <input type="number" class="form-control mx-2" name="inputRepeat" placeholder="7" required min="1" v-model="new_schedule.repeats_days">
                    days.
                </div>
            </div>
            <div class="form-group row">
                <label for="inputInstances" class="col-sm-3 col-form-label">
                    Instance(s)
                    <small id="instancesHelpBlock" class="form-text text-muted">
                        Select as many as you wish.
                    </small>
                </label>
                <div class="col-sm-9">
                    <div class="form-check" v-for="i in instances">
                        <input class="form-check-input" type="checkbox" name="inputInstances" :value="i.zone_id" v-model="new_schedule.instances" :id="i.abbr">
                        <label class="form-check-label" :for="i.abbr">
                            {{ i.name }}
                        </label>
                    </div>
                </div>
            </div>

        </form>
        <div slot="modal-footer">
            <button class="btn btn-success" id="btnConfirmScheduleNewRaid" @click="addRaid()">Confirm New Raid</button>
        </div>
    </b-modal>
    <table class="table table-striped my-6">
        <thead>
            <tr>
                <th scope="col">Instances</th>
                <th scope="col">Schedule</th>
                <th scope="col">Start Time</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="s in schedules">
                <td class="align-middle">
                    <ul class="mb-0">
                        <li v-for="i in s.instances">{{ i.name }}</li>
                    </ul>
                </td>
                <td class="align-middle">{{ s.schedule }}</td>
                <td class="align-middle">{{ s.start_time }}</td>
                <td class="align-top">
                    <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="Delete" @click="deleteRaid(s.id)">
                        <font-awesome-icon :icon="['fas', 'trash']"></font-awesome-icon>
                        <span class="sr-only">Delete</span>
                    </button>
                </td>
            </tr>
            <tr v-if="schedules.length == 0">
                <td colspan="4" class="text-center">There are no raids scheduled.</td>
            </tr>
        </tbody>
    </table>
</div>
</template>

<script>
export default {
    data: function() {
        return {
            new_schedule: {
                start: undefined,
                repeats_days: undefined,
                instances: [],
            },
            schedules: [],
        }
    },
    methods: {
        addRaid: function() {
            $('#formNewRaidSchedule').removeClass('needs-validation').addClass('was-validated')

            let form = this.$refs['formNewRaidSchedule']

            if (form.checkValidity()) {
                axios.post('/api/schedular/new', this.new_schedule)
                    .then(function(response) {
                        this.$refs['modalNewRaidSchedule'].hide()

                        // Reset new schedule back to normal...
                        this.new_schedule.start = undefined
                        this.new_schedule.repeats_days = undefined
                        this.new_schedule.instances = []
                    }.bind(this))
            }
        },
        deleteRaid: function (id) {
            axios.delete('/api/schedular/schedule/' + id)
                .then(this.refreshSchedules())
        },
        refreshSchedules: function () {
            axios.get('/api/schedular/schedules')
                .then(function(response) {
                    this.schedules = response.data
                }.bind(this))
        },
    },
    mounted: function() {
        this.refreshSchedules();
    },
    props: {
        instances: {
            type: Array,
            required: true,
        },
    }
}
</script>
