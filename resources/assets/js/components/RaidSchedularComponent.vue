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
                    <input type="number" class="form-control mx-2" name="inputRepeat" min="1" step="1" v-model="new_schedule.repeats_days" required>
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
            <div class="form-group row">
                <label for="inputCompilation" class="col-sm-3 col-form-label">
                    Raid Composition
                </label>
                <div class="col-sm-3">
                    <p>
                        <font-awesome-icon :icon="['fas', 'shield']" class="mr-2"></font-awesome-icon>
                        Tanks
                    </p>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-secondary" role="button" @click.prevent="decreaseComposition('tanks')">-</button>
                        </div>
                        <input class="form-control" type="number" min="0" max="40" step="1" v-model="raid_composition.tanks.total" />
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" role="button" @click.prevent="increaseComposition('tanks')">+</button>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <p>
                        <font-awesome-icon :icon="['fas', 'first-aid']" class="mr-2"></font-awesome-icon>
                        Healers
                    </p>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-secondary" role="button" @click.prevent="decreaseComposition('healers')">-</button>
                        </div>
                        <input class="form-control" type="number" min="0" max="40" step="1" v-model="raid_composition.healers.total" />
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" role="button" @click.prevent="increaseComposition('healers')">+</button>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <p>
                        <font-awesome-icon :icon="['fas', 'sword']" class="mr-2"></font-awesome-icon>
                        Damage
                    </p>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-secondary" role="button" @click.prevent="decreaseComposition('damage')">-</button>
                        </div>
                        <input class="form-control" type="number" min="0" max="40" step="1" v-model="raid_composition.damage.total" />
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" role="button" @click.prevent="increaseComposition('damage')">+</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="inputCompilation" class="col-sm-3 col-form-label">
                        Class Composition
                    </label>
                    <div class="col-sm-9">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="useClassCompositionCheckbox" name="useClassCompositionCheckbox" v-model="use_class_composition">
                            <label class="form-check-label" for="useClassCompositionCheckbox">
                                Use class composition?
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 offset-sm-3" v-if="use_class_composition">
                        <label for="classCompositionTankDruid" class="align-middle">
                            <img src="/images/ability_racial_bearform.jpg" alt="Bear Druid" height="28" class="mr-2" />
                            Druid
                        </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-secondary" role="button" @click.prevent="decreaseComposition('tanks', 'druid')">-</button>
                            </div>
                            <input class="form-control" id="classCompositionTankDruid" type="number" min="0" max="40" step="1" v-model="raid_composition.tanks.druid" disabled />
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" role="button" @click.prevent="increaseComposition('tanks', 'druid')">+</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3" v-if="use_class_composition">
                        <label for="classCompositionHealerDruid" class="align-middle">
                            <img src="/images/spell_nature_healingtouch.jpg" alt="Restoration Druid" height="28" class="mr-2" />
                            Druid
                        </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-secondary" role="button" @click.prevent="decreaseComposition('healers', 'druid')">-</button>
                            </div>
                            <input class="form-control" id="classCompositionHealerDruid" type="number" min="0" max="40" step="1" v-model="raid_composition.healers.druid" disabled />
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" role="button" @click.prevent="increaseComposition('healers', 'druid')">+</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3" v-if="use_class_composition">
                        <label for="classCompositionDamageDruid" class="align-middle">
                            <img src="/images/spell_nature_starfall.jpg" alt="Damage Druid" height="28" class="mr-2" />
                            Druid
                        </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-secondary" role="button" @click.prevent="decreaseComposition('damage', 'druid')">-</button>
                            </div>
                            <input class="form-control" id="classCompositionDamageDruid" type="number" min="0" max="40" step="1" v-model="raid_composition.damage.druid" disabled />
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" role="button" @click.prevent="increaseComposition('damage', 'druid')">+</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 offset-sm-3" v-if="use_class_composition">
                        <label for="classCompositionTankPaladin" class="align-middle">
                            <img src="/images/spell_holy_blessingofprotection.jpg" alt="Protection Paladin" height="28" class="mr-2" />
                            Paladin
                        </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-secondary" role="button" @click.prevent="decreaseComposition('tanks', 'paladin')">-</button>
                            </div>
                            <input class="form-control" id="classCompositionTankPaladin" type="number" min="0" max="40" step="1" v-model="raid_composition.tanks.paladin" disabled />
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" role="button" @click.prevent="increaseComposition('tanks', 'paladin')">+</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3" v-if="use_class_composition">
                        <label for="classCompositionHealerPaladin" class="align-middle">
                            <img src="/images/spell_holy_holybolt.jpg" alt="Holy Paladin" height="28" class="mr-2" />
                            Paladin
                        </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-secondary" role="button" @click.prevent="decreaseComposition('healers', 'paladin')">-</button>
                            </div>
                            <input class="form-control" id="classCompositionHealerPaladin" type="number" min="0" max="40" step="1" v-model="raid_composition.healers.paladin" disabled />
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" role="button" @click.prevent="increaseComposition('healers', 'paladin')">+</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3" v-if="use_class_composition">
                        <label for="classCompositionDamageHunter" class="align-middle">
                            <img src="/images/classicons_xs.png" alt="Hunter" height="28" class="class-icon class-icon-xs class-icon-hunter mr-2" />
                            Hunter
                        </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-secondary" role="button" @click.prevent="decreaseComposition('damage', 'hunter')">-</button>
                            </div>
                            <input class="form-control" id="classCompositionDamageHunter" type="number" min="0" max="40" step="1" v-model="raid_composition.damage.hunter" disabled />
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" role="button" @click.prevent="increaseComposition('damage', 'hunter')">+</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 offset-sm-3" v-if="use_class_composition">
                        <label for="classCompositionTankWarrior" class="align-middle">
                            <img src="/images/inv_shield_06.jpg" alt="Protection Warrior" height="28" class="mr-2" />
                            Warrior
                        </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-secondary" role="button" @click.prevent="decreaseComposition('tanks', 'warrior')">-</button>
                            </div>
                            <input class="form-control" id="classCompositionTankWarrior" type="number" min="0" max="40" step="1" v-model="raid_composition.tanks.warrior" disabled />
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" role="button" @click.prevent="increaseComposition('tanks', 'warrior')">+</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3" v-if="use_class_composition">
                        <label for="classCompositionHealerPriest" class="align-middle">
                            <img src="/images/classicons_xs.png" alt="Priest" height="28" class="class-icon class-icon-xs class-icon-priest mr-2" />
                            Priest
                        </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-secondary" role="button" @click.prevent="decreaseComposition('healers', 'priest')">-</button>
                            </div>
                            <input class="form-control" id="classCompositionHealerPriest" type="number" min="0" max="40" step="1" v-model="raid_composition.healers.priest" disabled />
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" role="button" @click.prevent="increaseComposition('healers', 'priest')">+</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3" v-if="use_class_composition">
                        <label for="classCompositionDamageMage" class="align-middle">
                            <img src="/images/classicons_xs.png" alt="Mage" height="28" class="class-icon class-icon-xs class-icon-mage mr-2" />
                            Mage
                        </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-secondary" role="button" @click.prevent="decreaseComposition('damage', 'mage')">-</button>
                            </div>
                            <input class="form-control" id="classCompositionDamageMage" type="number" min="0" max="40" step="1" v-model="raid_composition.damage.mage" disabled />
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" role="button" @click.prevent="increaseComposition('damage', 'mage')">+</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 offset-sm-9" v-if="use_class_composition">
                        <label for="classCompositionDamagePaladin" class="align-middle">
                            <img src="/images/spell_holy_auraoflight.jpg" alt="Retribution Paladin" height="28" class="mr-2" />
                            Paladin
                        </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-secondary" role="button" @click.prevent="decreaseComposition('damage', 'paladin')">-</button>
                            </div>
                            <input class="form-control" id="classCompositionDamagePaladin" type="number" min="0" max="40" step="1" v-model="raid_composition.damage.paladin" disabled />
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" role="button" @click.prevent="increaseComposition('damage', 'paladin')">+</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 offset-sm-9" v-if="use_class_composition">
                        <label for="classCompositionDamagePriest" class="align-middle">
                            <img src="/images/spell_shadow_shadowwordpain.jpg" alt="Shadow Priest" height="28" class="mr-2" />
                            Priest
                        </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-secondary" role="button" @click.prevent="decreaseComposition('damage', 'priest')">-</button>
                            </div>
                            <input class="form-control" id="classCompositionDamagePaladin" type="number" min="0" max="40" step="1" v-model="raid_composition.damage.priest" disabled />
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" role="button" @click.prevent="increaseComposition('damage', 'priest')">+</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 offset-sm-9" v-if="use_class_composition">
                        <label for="classCompositionDamageRogue" class="align-middle">
                            <img src="/images/classicons_xs.png" alt="Rogue" height="28" class="class-icon class-icon-xs class-icon-rogue mr-2" />
                            Rogue
                        </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-secondary" role="button" @click.prevent="decreaseComposition('damage', 'rogue')">-</button>
                            </div>
                            <input class="form-control" id="classCompositionDamageRogue" type="number" min="0" max="40" step="1" v-model="raid_composition.damage.rogue" disabled />
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" role="button" @click.prevent="increaseComposition('damage', 'rogue')">+</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 offset-sm-9" v-if="use_class_composition">
                        <label for="classCompositionDamageWarlock" class="align-middle">
                            <img src="/images/classicons_xs.png" alt="Warlock" height="28" class="class-icon class-icon-xs class-icon-warlock mr-2" />
                            Warlock
                        </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-secondary" role="button" @click.prevent="decreaseComposition('damage', 'warlock')">-</button>
                            </div>
                            <input class="form-control" id="classCompositionDamageWarlock" type="number" min="0" max="40" step="1" v-model="raid_composition.damage.warlock" disabled />
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" role="button" @click.prevent="increaseComposition('damage', 'warlock')">+</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 offset-sm-9" v-if="use_class_composition">
                        <label for="classCompositionDamageWarrior" class="align-middle">
                            <img src="/images/classicons_xs.png" alt="Warrior" height="28" class="class-icon class-icon-xs class-icon-warrior mr-2" />
                            Warrior
                        </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-secondary" role="button" @click.prevent="decreaseComposition('damage', 'warrior')">-</button>
                            </div>
                            <input class="form-control" id="classCompositionDamageWarrior" type="number" min="0" max="40" step="1" v-model="raid_composition.damage.warrior" disabled />
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" role="button" @click.prevent="increaseComposition('damage', 'warrior')">+</button>
                            </div>
                        </div>
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
            raid_composition: {
                tanks: {
                    total: 0,
                    druid: 0,
                    paladin: 0,
                    warrior: 0,
                },
                healers: {
                    total: 0,
                    druid: 0,
                    paladin: 0,
                    priest: 0,
                },
                damage: {
                    total: 0,
                    druid: 0,
                    hunter: 0,
                    mage: 0,
                    paladin: 0,
                    priest: 0,
                    rogue: 0,
                    warlock: 0,
                    warrior: 0,
                },
            },
            schedules: [],
            use_class_composition: false,
        }
    },
    methods: {
        addRaid: function() {
            $('#formNewRaidSchedule').removeClass('needs-validation').addClass('was-validated')

            let form = this.$refs['formNewRaidSchedule']

            if (form.checkValidity()) {
                axios.post('/api/schedular/new', {
                    schedule: this.new_schedule,
                    raid_composition: this.raid_composition,
                }).then(function(response) {
                        this.$refs['modalNewRaidSchedule'].hide()

                        // Reset new schedule back to normal...
                        this.new_schedule.start = undefined
                        this.new_schedule.repeats_days = undefined
                        this.new_schedule.instances = []


                        this.refreshSchedules()
                    }.bind(this))
            }
        },
        decreaseComposition: function (role, className = undefined) {
            this.raid_composition[role]['total']--
            if (className) {
                this.raid_composition[role][className]--
            }
        },
        deleteRaid: function (id) {
            axios.delete('/api/schedular/schedule/' + id)
                .then(this.refreshSchedules())
        },
        increaseComposition: function (role, className = undefined) {
            this.raid_composition[role]['total']++
            if (className) {
                this.raid_composition[role][className]++
            }
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
