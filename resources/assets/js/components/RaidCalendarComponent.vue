<template>
    <FullCalendar
        defaultView="dayGridMonth"
        :plugins="calendarPlugins"
        :events="raids"
    />
</template>

<script>
import FullCalendar from '@fullcalendar/vue'
import bootstrapPlugin from '@fullcalendar/bootstrap'
import dayGridPlugin from '@fullcalendar/daygrid'

export default {
    components: {
        FullCalendar // make the <FullCalendar> tag available
    },
    data: function () {
        return {
            calendarPlugins: [bootstrap, dayGridPlugin],
            raids: undefined,
        }
    },
    mounted: function () {
        axios.get('/api/schedular/schedules')
            .then(function(response) {
                raids = response.data
            }.bind(this))
    }
}
</script>
