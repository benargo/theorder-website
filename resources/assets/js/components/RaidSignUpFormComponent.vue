<template>
    <section id="RaidSignUpFormComponent">
        <div v-if="signup_id">
            <p>You have already signed up for this raid. Check back later to see if you were selected.</p>
            <p>You can cancel your signup if you can no longer make this raid. To do so, click the button below.</p>
            <p><button class="btn btn-primary" id="btnCancelSignUp" @click.prevent="cancelSignUp()">Withdraw from raid</button></p>
        </div>
        <form class="form needs-validation" id="formRaidSignUp" v-else>
            <p>Signups are currently open for this raid. Please complete the form below to sign up.</p>
            <div class="form-group">
                <label for="inputCharacterName">Character Name</label>
                <input type="text" class="form-control" id="inputCharacterName" maxlength="12" pattern="^[a-zA-ZÀ-ž]{1,12}" placeholder="Jaina" v-model="character_name" required />
                <div class="invalid-feedback">
                    Character names should be between 1 and 12 characters, and use letters only
                </div>
            </div>
            <div class="form-group">
                <label for="inputClassId">Class</label>
                <div class="class-icons">
                    <img src="/images/classicons.png" :alt="c.name" :class="classIconClass(c.name)" data-html="true" data-toggle="tooltip" data-placement="bottom" :title="c.name" v-for="c in classes" @click="handleIcon(c)" />
                </div>
                <input class="form-control d-none" type="number" name="inputClassId" v-model="class_id" required>
                <div class="invalid-feedback">
                    Please select a class
                </div>
            </div>
            <div class="form-group">
                <p>Role</p>
                <div class="btn-group btn-group-toggle position-static d-block">
                    <label :class="btnRoleClass('damage')" id="btnRoleDamage" for="radioRoleDamage">
                        <input class="form-control" type="radio" name="radioRole" id="radioRoleDamage" value="damage" v-model="role">
                        <font-awesome-icon :icon="['fas', 'sword']" class="mr-2"></font-awesome-icon>
                        Damage
                    </label>
                    <label :class="btnRoleClass('healer')" id="btnRoleHealer" for="radioRoleHealer">
                        <input class="form-control" type="radio" name="radioRole" id="radioRoleHealer" value="healer" v-model="role">
                        <font-awesome-icon :icon="['fas', 'first-aid']" class="mr-2"></font-awesome-icon>
                        Healer
                    </label>
                    <label :class="btnRoleClass('tank')" id="btnRoleTank" for="radioRoleTank">
                        <input class="form-control" type="radio" name="radioRole" id="radioRoleTank" value="tank" v-model="role">
                        <font-awesome-icon :icon="['fas', 'shield']" class="mr-2"></font-awesome-icon>
                        Tank
                    </label>
                </div>
            </div>
            <div class="form-group mb-3">
                <button class="btn btn-primary" @click.prevent="submitForm()">Sign up</button>
            </div>
        </form>
    </section>
</template>

<script>
export default {
    data: function () {
        return {
            character_name: undefined,
            class_id: undefined,
            role: undefined,
            signup_id: undefined,
        }
    },
    methods: {
        btnRoleClass: function (role) {
            let css_class = 'btn btn-secondary'

            if (role == this.role) {
                css_class = css_class.concat(' active')
            }

            return css_class
        },
        cancelSignUp: function () {
            axios.delete('/api/raids/'+this.raidId+'/signup/'+this.signup_id)
                 .then(function (response) {
                     this.signup_id = undefined
                 }.bind(this))
        },
        classIconClass: function (name) {
            return 'class-icon class-icon-' + window.kebabCase(name)
        },
        handleIcon: function (c) {
            this.class_id = c.id

            $('.class-icon').removeClass('active')
            $('.class-icon-' + window.kebabCase(c.name)).addClass('active')
        },
        submitForm: function () {
            $('#formRaidSignUp').removeClass('needs-validation').addClass('was-validated')

            let form = this.$el.querySelector('#formRaidSignUp')

            if (form.checkValidity()) {
                axios.post('/api/raids/'+this.raidId+'/signup', {
                        character_name: this.character_name,
                        class_id: this.class_id,
                        role: this.role,
                    })
                    .then(function(response) {
                        this.signup_id = response.data.id
                    }.bind(this))
            }
        }
    },
    mounted() {
        this.character_name = this.defaultCharacterName
        this.class_id = this.defaultClassId
        this.role = this.defaultRole
        this.signup_id = this.signedUp
    },
    props: {
        classes: Object,
        defaultCharacterName: String,
        defaultClassId: Number,
        defaultRole: String,
        raidId: Number,
        signedUp: {
            type: Number,
            default: undefined,
        },
    }
}
</script>
