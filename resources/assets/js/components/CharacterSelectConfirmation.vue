<template>
    <b-alert :show="dismissCountDown"
             v-on:characterUpdated="showAlert"
             dismissible
             variant="success"
             @dismissed="dismissCountDown=0"
             @dismiss-count-down="10">
        <p>{{ lang }}</p>
    </b-alert>
</template>

<script>
    export default {
        data: function () {
            return {
                dismissSecs: 10,
                dismissCountDown: 0,
                showDismissibleAlert: false
            };
        },
        methods: {
            showAlert () {
                this.dismissCountDown = 10
            },
        },
        props: {
            lang: String,
        }
    }
</script>
