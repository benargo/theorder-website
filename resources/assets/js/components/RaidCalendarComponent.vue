<template>
    <FullCalendar
        :bootstrap-font-awesome="false"
        :button-text="{
            prev: 'previous',
            next: 'next'
        }"
        default-view="dayGridMonth"
        :first-day="1"
        :events="raids"
        :event-time-format="{
            hour: '2-digit',
            minute: '2-digit',
            omitZeroMinute: false,
            meridiem: false,
            hour12: false,
        }"
        :plugins="calendarPlugins"
        :slot-label-format="{
            hour: '2-digit',
            minute: '2-digit',
            omitZeroMinute: false,
            meridiem: false,
            hour12: true,
        }"
        theme-system="bootstrap"
    />
</template>

<script>
import {
    FontAwesomeIcon
} from '@fortawesome/vue-fontawesome'
import FullCalendar from '@fullcalendar/vue'
import bootstrapPlugin from '@fullcalendar/bootstrap'
import dayGridPlugin from '@fullcalendar/daygrid'

export default {
    components: {
        FullCalendar // make the <FullCalendar> tag available
    },
    data: function () {
        return {
            calendarPlugins: [bootstrapPlugin, dayGridPlugin],
            raids: [],
        }
    },
    mounted: function () {
        axios.get('/api/schedular/raids')
            .then(function(response) {
                let raids = response.data

                // Loop over the new raids object and match it to the Event
                // object...
                raids.forEach(function (item, index) {
                    item.title = item.instances.map(instance => instance.name).join('/')
                    item.start = item.starts_at

                    // Remove redundant properties...
                    delete item.starts_at
                })

                this.raids = raids;
            }.bind(this))
    }
}
</script>
