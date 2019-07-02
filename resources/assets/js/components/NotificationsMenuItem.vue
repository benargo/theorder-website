<template>
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="notificationsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <font-awesome-icon :icon="bellIcon" class="nav-icon"></font-awesome-icon>
        {{ lang.notifications }}
        <span v-show="notifications.length >= 1" class="badge badge-light">{{ notifications.length }}</span>
    </a>
    <div class="dropdown-menu dropdown-menu-right bg-brown" aria-labelledby="notificationsDropdown">
        <a v-for="notification in notifications" class="dropdown-item nav-link" :href="getNotificationUrl(notification)">{{ notification.data.title }}</a>
        <div v-show="notifications.length >= 1" class="dropdown-divider"></div>
        <a class="dropdown-item nav-link disabled" href="/notifications" tabindex="-1" aria-disabled="true">
            <font-awesome-icon :icon="['far', 'history']"></font-awesome-icon>
            {{ lang.notifications_history }}
        </a>
    </div>
</li>
</template>

<script>
export default {
    computed: {
        bellIcon: function() {
            return (this.notifications.length > 0 ? ['fas', 'bell'] : ['far', 'bell'])
        },
    },
    data: function() {
        return {
            notifications: []
        }
    },
    methods: {
        getNotificationUrl: function(notification) {
            console.log(notification)
            return '/notifications/'.notification.id
        },
    },
    mounted: function() {
        let component = this

        axios.get('/api/notifications/unread')
            .then(function(response) {
                component.notifications = response.data
            })
    },
    props: {
        lang: {
            type: Object,
            required: true
        },
    },
}
</script>
