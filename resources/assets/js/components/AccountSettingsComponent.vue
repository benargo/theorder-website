<template>
<form>
    <div class="form-row mb-3">
        <div class="col needs-validation" id="formGroupNickname">
            <label for="inputNickname">Nickname</label>
            <input type="text" class="form-control" id="inputNickname" maxlength="32" pattern="^[a-zA-Z0-9]{3,32}" v-model="nickname" @blur="saveNickname()" @focus="enableValidation('formGroupNickname')" />
            <div class="invalid-feedback">Nicknames must be between (3) and (32) characters, and use only letters and numbers.</div>
            <div class="valid-feedback">Looks good!</div>
        </div>
        <div class="col needs-validation" id="formGroupEmail">
            <label for="inputEmail">Email</label>
            <input type="email" class="form-control" id="inputEmail" v-model="email" @blur="saveEmail()" @focus="enableValidation('formGroupEmail')" />
            <div class="invalid-feedback">Must be a valid email address.</div>
            <div class="valid-feedback">Looks good!</div>
        </div>
    </div>
    <div class="form-row mb-3">
        <div class="col">
            <label for="inputBattleTag">Blizzard Battletag&trade;</label>
            <input type="text" class="form-control" id="inputBattleTag" :value="defaultValues.battletag" disabled>
        </div>
        <div class="col">
            <label for="inputDiscordTag">Discord Tag</label>
            <div class="input-group" v-if="discordTag">
                <input type="text" class="form-control" id="inputDiscordTag" v-model="discordTag" disabled>
                <div class="input-group-append">
                    <button class="btn btn-outline-primary" id="btnUnlinkDiscord" type="button" @click="unlinkDiscord()">Unlink</button>
                </div>
            </div>
            <div class="input-group" v-else>
                <a href="/discord/link" class="btn btn-primary" id="btnLinkDiscord">Link Discord account</a>
            </div>
        </div>
    </div>
</form>
</template>

<script>
export default {

    data: function() {
        return {
            nickname: undefined,
            email: undefined,
            discordTag: undefined,
            validEmailPattern: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
        }
    },

    methods: {

        enableValidation: function(elementId) {
            $('#' + elementId).removeClass('needs-validation').addClass('was-validated')
        },

        saveEmail: function() {
            axios.put('/api/user/' + this.userId + '/email', {
                value: this.email,
            })
        },

        saveNickname: function() {
            axios.put('/api/user/' + this.userId + '/nickname', {
                    value: this.nickname,
                })
                .then(function(response) {
                    $('#authDropdown').text(this.nickname)
                }.bind(this))

        },

        unlinkDiscord: function() {
            axios.post('/api/user/' + this.userId + '/unlink-discord')
                .then(function(response) {
                    this.discordTag = undefined
                }.bind(this));
        }

    },

    mounted: function() {
        this.nickname = this.defaultValues.nickname
        this.email = this.defaultValues.email
        this.discordTag = this.defaultValues.discordTag
    },

    props: {

        defaultValues: {
            type: Object,
            validator: function(obj) {
                return (
                    obj.hasOwnProperty('nickname') &&
                    obj.hasOwnProperty('email') &&
                    obj.hasOwnProperty('battletag') &&
                    obj.hasOwnProperty('discordTag')
                );
            },
        },

        userId: {
            type: Number,
            required: true,
        },

    },

}
</script>
