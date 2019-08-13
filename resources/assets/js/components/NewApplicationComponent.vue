<template>
<section id="NewApplicationComponent">
    <div id="applicationAccepted" v-if="status === 'accepted'">
        <div class="alert alert-success text-center" role="alert">
            {{ lang.alerts.applicationAccepted }}
        </div>
    </div>
    <div id="applicationDeclined" v-else-if="status === 'declined'">
        <div class="alert alert-danger text-center" role="alert">
            {{ lang.alerts.applicationDeclined }}
        </div>
    </div>
    <div id="applicationPending" v-else-if="status === 'pending'">
        <div class="alert alert-info" role="alert" v-html="applicationPending"></div>
    </div>
    <div id="applicationSubmitted" v-else-if="applicationSubmitted">
        <div class="alert alert-success text-center" role="alert">
            {{ lang.alerts.applicationSubmitted }}
        </div>
        <p v-html="nextSteps"></p>
    </div>
    <form class="needs-validation" id="formApplication" v-else>
        <div class="form-row">
            <div class="form-group col">
                <label for="inputCharacterName">{{ lang.characterName }}</label>
                <input type="text" class="form-control" id="inputCharacterName" maxlength="12" pattern="^[a-zA-ZÀ-ž]{1,12}" placeholder="Jaina" required v-model="characterName" />
                <div class="invalid-feedback">
                    {{ lang.errors.characterNameInvalid }}
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col">
                <label for="inputRace">{{ lang.race }}</label>

                <div class="race-icons">
                    <img src="/images/raceicons.png" :alt="r.name" :class="raceIconClass(r.name)" data-html="true" data-toggle="tooltip" data-placement="bottom" :title="r.name" v-for="r in races" @click="handleIcon('race', r)" />
                </div>
                <input class="form-control d-none" type="number" name="inputRace" v-model="raceId" required>
                <div class="invalid-feedback">
                    {{ lang.errors.noRaceSelected }}
                </div>
            </div>
            <div class="form-group col">
                <label for="inputClass">{{ lang.class }}</label>
                <div class="class-icons">
                    <img src="/images/classicons.png" :alt="c.name" :class="classIconClass(c.name)" data-html="true" data-toggle="tooltip" data-placement="bottom" :title="c.name" v-for="c in classes" @click="handleIcon('class', c)" />
                </div>
                <input class="form-control d-none" type="number" name="inputClass" v-model="classId" required>
                <div class="invalid-feedback">
                    {{ lang.errors.noClassSelected }}
                </div>
            </div>
        </div>
        <div class="form-group">
            <p>{{ lang.role }}</p>
            <div class="btn-group btn-group-toggle position-static d-block">
                <label class="btn btn-secondary" id="btnRoleDamage" for="radioRoleDamage">
                    <input class="form-control" type="radio" name="radioRole" id="radioRoleDamage" value="damage" v-model="role">
                    <font-awesome-icon :icon="['fas', 'sword']"></font-awesome-icon>
                    Damage
                </label>
                <label class="btn btn-secondary" id="btnRoleHealer" for="radioRoleHealer">
                    <input class="form-control" type="radio" name="radioRole" id="radioRoleHealer" value="healer" v-model="role">
                    <font-awesome-icon :icon="['fas', 'first-aid']"></font-awesome-icon>
                    Healer
                </label>
                <label class="btn btn-secondary" id="btnRoleTank" for="radioRoleTank">
                    <input class="form-control" type="radio" name="radioRole" id="radioRoleTank" value="tank" v-model="role">
                    <font-awesome-icon :icon="['fas', 'shield']"></font-awesome-icon>
                    Tank
                </label>
            </div>
        </div>
        <div class="form-row mb-3">
            <div class="col">
                <button class="btn btn-primary" @click.prevent="submitForm()">Submit Application</button>
            </div>
        </div>
    </form>
</section>
</template>

<script>
export default {
    data: function() {

        return {
            applicationSubmitted: false,
            characterName: undefined,
            classId: undefined,
            raceId: undefined,
            role: 'damage',
        }

    },

    methods: {
        btnRoleClass: function (role) {
            let css_class = 'btn btn-secondary'

            if (role == this.role) {
                css_class = css_class.concat(' active')
            }
        },

        classIconClass: function(name) {
            return 'class-icon class-icon-' + window.kebabCase(name)
        },

        handleIcon: function(type, rc) {
            if (type === 'class') {
                this.classId = rc.id

                $('.class-icon').removeClass('active')
                $('.class-icon-' + window.kebabCase(rc.name)).addClass('active')
            } else if (type === 'race') {
                this.raceId = rc.id

                $('.race-icon').removeClass('active')
                $('.race-icon-' + window.kebabCase(rc.name)).addClass('active')
            }
        },

        raceIconClass: function(name) {
            return 'race-icon race-icon-' + window.kebabCase(name)
        },

        submitForm: function() {
            $('#formApplication').removeClass('needs-validation').addClass('was-validated')

            let form = this.$el.querySelector('#formApplication')

            if (form.checkValidity()) {
                axios.post('/api/applications/new', {
                        characterName: this.characterName,
                        classId: this.classId,
                        raceId: this.raceId,
                        role: this.role,
                    })
                    .then(function(response) {
                        this.applicationSubmitted = true
                    }.bind(this))
            }

        },
    },

    props: {

        classes: {
            type: Object,
            required: true,
        },

        discordUrl: {
            type: String,
            required: true,
        },

        races: {
            type: Object,
            required: true,
        },

        lang: {
            type: Object,
            required: true,
        },

        status: String,

    },

    watch: {
        role: function (new_role) {
            this.$el.querySelectorAll('.btn-group.btn-group-toggle label.btn').forEach(function (el) {
                el.classList.remove('active')
            })

            new_role = new_role.charAt(0).toUpperCase() + new_role.slice(1);
            this.$el.querySelector('#btnRole' + new_role).classList.add('active');
        }
    }

}
</script>
