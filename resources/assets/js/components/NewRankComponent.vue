<template>
<div class="row">
    <div class="col text-md-right">
        <button class="btn btn-primary btn-lg" v-b-modal.modalNewRank>
            <font-awesome-icon :icon="['fas', 'layer-plus']"></font-awesome-icon>
            {{ lang.btnNewRank }}
        </button>
    </div>
    <b-modal id="modalNewRank" size="xl" :title="lang.btnNewRank" busy>
        <form class="needs-validation" id="formNewRank">
            <div class="form-group row">
                <label for="inputTitle" class="col-sm-2 col-form-lavel">{{ lang.hdrTitle }}</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputTitle" placeholder="Member" v-model="title" required>
                    <div class="invalid-feedback">
                        {{ lang.errTitle }}
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputSeniority" class="col-sm-2 col-form-lavel">{{ lang.hdrSeniority }}</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" id="inputSeniority" min="1" max="25" v-model.number="seniority" placeholder="1-25" required>
                    <div class="invalid-feedback">
                        {{ lang.errSeniority }}
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputKudosPerDay" class="col-sm-2 col-form-lavel">{{ lang.hdrKudosPerDay }}</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" id="inputKudosPerDay" min="0" max="100" v-model.number="kudos_per_day" placeholder="0-100, or leave blank for unlimited">
                    <div class="invalid-feedback">
                        {{ lang.errKudosPerDay }}
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputKudosRequired" class="col-sm-2 col-form-lavel">{{ lang.hdrKudosRequired }}</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" id="inputKudosRequired" min="0" v-model.number="kudos_required" placeholder="> 0" required>
                    <div class="invalid-feedback">
                        {{ lang.errKudosRequired }}
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputDiscordRole" class="col-sm-2 col-form-lavel">{{ lang.hdrDiscordRole }}</label>
                <div class="col-sm-10">
                    <select class="form-control" id="inputDiscordRole" v-model="discord_role" required>
                        <option value=""></option>
                        <option :value="r.id" v-for="r in discordRolesSorted">{{ r.name }}</option>
                    </select>
                    <div class="invalid-feedback">
                        {{ lang.errEmpty }}
                    </div>
                </div>
            </div>
        </form>
        <div slot="modal-footer">
            <button class="btn btn-primary" id="btnConfirmCreateRank" @click="createRank()">{{ lang.btnCreateRank }}</button>
        </div>
    </b-modal>
</div>
</template>

<script>
export default {
    computed: {
        discordRolesSorted: function() {
            return this.discordRoles.filter(role => role.managed === false).sort(function(a, b) {
                return a.position > b.position ? -1 : 1
            })
        },
    },

    data: function() {
        return {
            title: undefined,
            seniority: undefined,
            kudos_per_day: undefined,
            kudos_required: undefined,
            discord_role: undefined,
        }
    },

    methods: {
        createRank: function() {
            let form = document.querySelector('#formNewRank');

            form.classList.replace('needs-validation', 'was-validated')

            if (form.checkValidity()) {
                axios.post('/api/ranks/new', {
                    title: this.title,
                    seniority: this.seniority,
                    kudos_per_day: this.kudos_per_day,
                    kudos_required: this.kudos_required,
                    discord_role: this.discord_role,
                }).then(function(response) {
                    this.$parent.$refs.RanksManagerComponent.fetchRanks()
                }.bind(this))
            }
        },
    },

    props: {
        discordRoles: {
            type: Array,
            required: true,
        },

        lang: {
            type: Object,
            required: true,
        },
    },
}
</script>
