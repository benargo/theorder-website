<template>
<section id="NewApplicationComponent">
    <div id="applicationDeclined" v-if="status === 'declined'">
        <div class="alert alert-danger text-center" role="alert">
            Your application was previously declined and you must wait until {{ cannotApplyAgainUntilDate }} before applying again.
        </div>
    </div>
    <div id="applicationPending" v-else-if="status === 'pending'">
        <div class="alert alert-info" role="alert">
            Your application is pending review by one of the Inner Circle. They will be in touch with you soon; either in-game or via <strong><a :href="discordUrl" class="text-info">Discord</a></strong>. You can also check back here at any time to see the status of your application.
        </div>
    </div>
    <div id="applicationSubmitted" v-else-if="applicationSubmitted">
        <div class="alert alert-success text-center" role="alert">
            Relax! Your application has been received and one of the Inner Circle will be in touch with you soon.
        </div>
    </div>
    <form class="needs-validation" id="formApplication" v-else>
        <div id="applicationAccepted" v-if="status === 'accepted'">
            <div class="alert alert-success text-center" role="alert">
                Your application was previously accepted. Unless you previously left the guild, there’s little point applying again.
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col">
                <label for="inputCharacterName">Character Name</label>
                <input type="text" class="form-control" id="inputCharacterName" maxlength="12" pattern="^[a-zA-ZÀ-ž]{1,12}" placeholder="Jaina" required v-model="characterName" />
                <div class="invalid-feedback">
                    Character names should be between 1 and 12 characters, and use letters only
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col">
                <label for="inputRace">Race</label>

                <div class="race-icons">
                    <img src="/images/raceicons.png" :alt="r.name" :class="raceIconClass(r.name)" data-html="true" data-toggle="tooltip" data-placement="bottom" :title="r.name" v-for="r in races" @click="handleIcon('race', r)" />
                </div>
                <input class="form-control d-none" type="number" name="inputRace" v-model="raceId" required>
                <div class="invalid-feedback">
                    Please select a race
                </div>
            </div>
            <div class="form-group col">
                <label for="inputClass">Class</label>
                <div class="class-icons">
                    <img src="/images/classicons.png" :alt="c.name" :class="classIconClass(c.name)" data-html="true" data-toggle="tooltip" data-placement="bottom" :title="c.name" v-for="c in classes" @click="handleIcon('class', c)" />
                </div>
                <input class="form-control d-none" type="number" name="inputClass" v-model="classId" required>
                <div class="invalid-feedback">
                    Please select a class
                </div>
            </div>
        </div>
        <div class="form-group">
            <p>Role</p>
            <div class="btn-group btn-group-toggle position-static d-block">
                <label class="btn btn-secondary active" id="btnRoleDamage" for="radioRoleDamage">
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
        cannotApplyAgainUntilDate: {
            type: String,
            required: true,
        },

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
