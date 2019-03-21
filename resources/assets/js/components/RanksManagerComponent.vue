<template>
    <div class="container">
        <div class="row">
            <div class="col">
                <form class="needs-validating" id="formManageRanks">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 25%">{{ lang.hdrTitle }}</th>
                                <th scope="col" style="width: 12.50%">{{ lang.hdrSeniority }}</th>
                                <th scope="col" style="width: 12.50%">{{ lang.hdrKudosPerDay }}</th>
                                <th scope="col" style="width: 12.50%">{{ lang.hdrKudosRequired }}</th>
                                <th scope="col" style="width: 25%">{{ lang.hdrDiscordRole }}</th>
                                <th scope="col" style="width: 12.50%">{{ lang.hdrActions }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr :id="'rank' + index" v-for="(r, index) in ranks">
                                <th scope="row" class="form-col title" @click="editCell(index, 'title')" @focus="editCell(r.id, 'title')">
                                    <span class="form-static align-middle">{{ r.title }}</span>
                                    <input type="text" class="form-control d-none" name="inputTitle" required v-model="r.title">
                                    <div class="invalid-feedback">
                                        {{ lang.errTitle }}
                                    </div>
                                </th>
                                <td class="form-col  seniority" @click="editCell(index, 'seniority')" @focus="editCell(index, 'seniority')">
                                    <span class="form-static align-middle">{{ r.seniority }}</span>
                                    <input type="number" class="form-control d-none" name="inputSeniority" min="1" max="25" required v-model="r.seniority">
                                    <div class="invalid-feedback">
                                        {{ lang.errSeniority }}
                                    </div>
                                </td>
                                <td class="form-col kudos-per-day" @click="editCell(index, 'kudos-per-day')" @focus="editCell(index, 'kudos_per_day')">
                                    <span class="form-static align-middle" v-html="kudosPerDay(r.kudos_per_day)"></span>
                                    <input type="number" class="form-control d-none" name="inputKudosPerDay" min="0" max="100" v-model="r.kudos_per_day">
                                    <div class="invalid-feedback">
                                        {{ lang.errKudosPerDay }}
                                    </div>
                                </td>
                                <td class="form-col kudos-required" @click="editCell(index, 'kudos-required')" @focus="editCell(index, 'kudos_required')">
                                    <span class="form-static align-middle">{{ r.kudos_required }}</span>
                                    <input type="number" class="form-control d-none" name="inputKudosRequired" min="0" required v-model="r.kudos_required">
                                    <div class="invalid-feedback">
                                        {{ lang.errKudosRequired }}
                                    </div>
                                </td>
                                <td class="form-col discord-role" @click="editCell(index, 'discord-role')" @focus="editCell(index, 'discord_role')">
                                    <span class="form-static align-middle" :style="styleDiscordRole(r.discord_role)">{{ getDiscordRole(r.discord_role).name }}</span>
                                    <select class="form-control d-none" name="inputDiscordRole" v-model="r.discord_role">
                                        <option value="">{{ lang.noRole }}</option>
                                        <option v-for="dr in discordRolesSorted" :value="dr.id" :style="styleDiscordRole(dr.id)">{{ dr.name }}</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        {{ lang.errEmpty }}
                                    </div>
                                </td>
                                <td class="align-top">
                                    <button type="button"
                                            class="btn btn-primary"
                                            data-toggle="tooltip"
                                            data-placement="bottom"
                                            :title="lang.btnSave"
                                            v-if="editingRow === index"
                                            @click="saveRow(index)">
                                        <font-awesome-icon :icon="['fas', 'save']"></font-awesome-icon>
                                        <span class="sr-only">{{ lang.btnSave }}</span>
                                    </button>
                                    <button type="button"
                                            class="btn btn-primary"
                                            data-toggle="tooltip"
                                            data-placement="bottom"
                                            :title="lang.btnEdit"
                                            v-else
                                            @click="editRow(index)">
                                        <font-awesome-icon :icon="['fas', 'pencil']"></font-awesome-icon>
                                        <span class="sr-only">{{ lang.btnEdit }}</span>
                                    </button>
                                    <button type="button"
                                            class="btn btn-primary"
                                            data-toggle="tooltip"
                                            data-placement="bottom"
                                            :title="lang.btnDelete"
                                            @click="deleteRank(r.id)">
                                        <font-awesome-icon :icon="['fas', 'trash']"></font-awesome-icon>
                                        <span class="sr-only">{{ lang.btnEdit }}</span>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
        <b-modal id="modalDelete" ref="modalDelete" :title="lang.areYouSure" busy>
            <section v-html="lang.warnDeleteIsPermanent"></section>
            <form class="needs-validation" id="formDeleteRank" v-if="rankToDelete.usersToMove > 0">
                <p>{{ lang.usersToMoveLead }}</p>
                <div class="form-group">
                    <label for="inputNewRank">{{ lang.hdrNewRank }}</label>
                    <select class="form-control" name="inputNewRank" id="inputNewRank" required v-model="rankToDelete.newRank">
                        <option value=""></option>
                        <option :value="r.id" v-for="r in getRanks()">{{ r.title }}</option>
                    </select>
                    <div class="invalid-feedback">
                        {{ lang.errEmpty }}
                    </div>
                </div>
                <p class="small">{{ lang.usersToMoveSmall }}</p>
            </form>
            <div slot="modal-footer">
                <b-button type="submit" variant="danger" id="btnConfirmDeleteRank" @click="deleteRankConfirm()">{{ lang.btnDelete }}</b-button>
            </div>
        </b-modal>
    </div>
</template>

<script>
    export default {
        computed: {
            discordRolesSorted: function () {
                return this.discordRoles.filter(role => role.managed === false).sort(function (a,b) {
                    return a.position > b.position ? -1 : 1
                })
            },
        },

        data: function () {
            return {
                editingRow: false,
                ranks: [],
                rankToDelete: {
                    newRank: undefined,
                    rankId: undefined,
                    usersToMove: 0,
                },
            }
        },

        methods: {
            deleteRank: function (rankId) {
                axios.get('/api/ranks/' + rankId + '/users').then(function (response) {
                    let users = response.data

                    this.rankToDelete.rankId = rankId
                    this.rankToDelete.usersToMove = users.length

                    this.$refs.modalDelete.show()
                 }.bind(this))
            },

            deleteRankConfirm: function () {
                let form = this.$el.querySelector('#formDeleteRank')

                if (form) {
                    form.classList.replace('needs-validation', 'was-validated')

                    if (! form.checkValidity()) return
                }
                
                axios.delete('/api/ranks/' + this.rankToDelete.rankId, {
                    data: {
                        new_rank: this.rankToDelete.newRank,
                    },
                }).then(function (response) {
                    this.fetchRanks()

                    $('#modalDelete').modal('hide')
                }.bind(this))
            },

            editCell: function (rowId, field) {
                let cell  = this.$el.querySelector('#rank' + rowId + ' .' + field),
                    span  = cell.querySelector('span.form-static'),
                    input = cell.querySelector('.form-control[name^="input"]')

                span.classList.add('d-none')
                input.classList.replace('d-none', 'd-block')
                input.focus()
            },

            editRow: function (rowId) {
                let row   = this.$el.querySelector('#rank' + rowId),
                    cells = row.querySelectorAll('.form-col')

                cells.forEach(function (cell, i) {
                    let span  = cell.querySelector('span.form-static'),
                        input = cell.querySelector('.form-control[name^="input"]')

                    span.classList.add('d-none')
                    input.classList.replace('d-none', 'd-block')
                })

                this.editingRow = rowId

                row.querySelector('input[name="inputTitle"]').focus()
            },

            fetchRanks: function () {
                axios.get('/api/ranks')
                     .then(function (response) {
                         this.ranks = response.data
                     }.bind(this))
            },

            getRanks: function () {
                if (this.rankToDelete.rankId) {
                    return this.ranks.filter(rank => rank.id != this.rankToDelete.rankId)
                }

                return this.ranks
            },

            getDiscordRole: function (dr) {
                let role = this.discordRoles.find(function (el) {
                    return el.id === dr
                }.bind(dr))

                return role ? role : {}
            },

            kudosPerDay: function (k) {
                return k === null || k === '' ? '<abbr title="' + this.lang.fieldUnlimited + '">' + this.lang.abbrUnlimited + '</abbr>' : k
            },

            saveRow: function (index) {
                let form = this.$el.querySelector('#formManageRanks'),
                    rank = this.ranks[index]

                if (form.checkValidity()) {
                    axios.put('/api/ranks/' + rank.id, {
                        title:          rank.title,
                        seniority:      rank.seniority,
                        kudos_per_day:  rank.kudos_per_day,
                        kudos_required: rank.kudos_required,
                        discord_role:   rank.discord_role,
                    })
                    .then(function (response) {
                        this.fetchRanks()

                        let inputs = this.$el.querySelectorAll('.form-control[name^="input"]'),
                            spans  = this.$el.querySelectorAll('span.form-static')

                        inputs.forEach(function (i) {
                            i.classList.replace('d-block', 'd-none')
                        })
                        spans.forEach(function (s) {
                            s.classList.remove('d-none')
                        })

                        this.editingRow = false
                    }.bind(this))
                }
            },

            styleDiscordRole: function (dr) {
                let role = this.getDiscordRole(dr)

                if (role.color) {
                    let hexColor = '#' + Number(role.color).toString(16).toLowerCase()

                    return {
                        color: hexColor,
                    }
                }
            },
        },

        mounted: function () {
            this.fetchRanks()
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

        updated: function () {
            // Initialise tooltips and validation...
            $('[data-toggle="tooltip"]').tooltip()
            $('#formManageRanks').removeClass('needs-validation').addClass('was-validated')
        },
    }
</script>
