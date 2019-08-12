<template>
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="notificationsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" @click="refreshNotifications()">
        <font-awesome-icon :icon="bellIcon" class="nav-icon"></font-awesome-icon>
        {{ lang.notifications }}
        <span v-show="notifications.length >= 1" class="badge badge-light">{{ notifications.length }}</span>
    </a>
    <div class="dropdown-menu dropdown-menu-right bg-brown" aria-labelledby="notificationsDropdown">
        <a v-for="notification in notifications" class="dropdown-item nav-link border-bottom" :href="getNotificationUrl(notification)">
            <p>{{ notification.data.title }}</p>
            <small v-if="notification.data.subtitle">{{ notification.data.subtitle }}</small>
        </a>
        <a class="dropdown-item nav-link disabled text-muted" href="/notifications" tabindex="-1" aria-disabled="true">
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
            return '/notifications/' + notification.id
        },

        refreshNotifications: function() {
            axios.get('/api/notifications/unread').then(function(response) {
                this.notifications = response.data
            }.bind(this))
        },

    },
    mounted: function() {
        this.refreshNotifications()
    },
    props: {
        lang: {
            type: Object,
            required: true
        },
    },
}
</script>
