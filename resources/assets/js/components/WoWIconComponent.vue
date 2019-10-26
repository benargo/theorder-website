<template>
<img :src="iconUrl" :alt="name"></img>
</template>

<script>
export default {

    computed: {
        iconUrl: function () {
            return 'https://render-eu.worldofwarcraft.com/icons/56/' + this.name + '.jpg';
        },
    },

    props: {
        name: {
            type: String,
            required: true,
        },
    },
}
</script>
