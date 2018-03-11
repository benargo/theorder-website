<template>
    <div class="col-12 col-md-4">
        <a class="character-select-button" href="#" role="button" @click.prevent="setPrimaryCharacter">
            <img class="character-select-avatar" :src="avatarUrl" alt="" width="84">
            <div class="character-select-body">
                <h3 class="card-title">{{ name }}</h3>
                <p class="card-text">{{ summary }}</p>
            </div>
        </a>
    </div>
</template>

<script>
    export default {
        computed: {
            apiUrl: function () {
                return '/api/primary-character/'+this.user;
            },
            avatarUrl: function () {
                return 'https://render-api-eu.worldofwarcraft.com/static-render/eu/'+this.thumbnail
            },
        },
        data: function () {
            return {
                user: document.querySelector('meta[name="x-user-id"]').getAttribute('content'),
            };
        },
        methods: {
            setPrimaryCharacter: function () {
                axios.put(this.apiUrl, {
                    region: this.region,
                    realm: this.realm,
                    name: this.name,
                })
                .then(this.confirmUpdate())
                .catch(function (e) {

                });
            },
            confirmUpdate: function (response = undefined) {
                this.$emit('characterUpdated');
            },
        },
        props: {
            is_main: {
                type: Boolean,
                default: false,
            },
            name: {
                type: String,
                required: true,
            },
            realm: {
                type: String,
                required: true,
            },
            region: {
                type: String,
                default: 'eu',
            },
            summary: {
                type: String,
                required: true,
            },
            thumbnail: String,
        }
    }
</script>
