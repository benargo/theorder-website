<template>
<div class="container my-7">
    <p class="lead">Welcome to the marketplace! Please look around, browse our wares, and let me know if you see anything you like!</p>

    <!-- Step 1: Customer or Shopkeeper?  -->
    <section id="marketplaceProfile" class="my-5">
        <h3 class="h4 mb-3">What would you like to do today?</h3>
        <div class="row">
            <div class="col btn-group btn-group-toggle">
                <label class="btn btn-outline-primary btn-lg w-50" id="btnStepOneBuy" for="inputStepOneBuy">
                    <input type="radio" name="profile" v-model="progress.stepOne" id="inputStepOneBuy" value="buy">
                    I'm looking for something
                </label>
                <label class="btn btn-outline-primary btn-lg w-50" id="btnStepOneSell" for="inputStepOneSell">
                    <input type="radio" name="profile" v-model="progress.stepOne" id="inputStepOneSell" value="sell">
                    I've got stuff to sell
                </label>
            </div>
        </div>
    </section>

    <!-- Step 2: Buy -->
    <section id="marketplaceAction" class="my-5" v-if="progress.stepOne == 'buy'">
        <h3 class="h4 mb-3">What are you looking for?</h3>
        <div class="row">
            <div class="col btn-group btn-group-toggle">
                <label class="btn btn-outline-primary btn-lg w-50" id="btnStepTwo" for="inputStepTwo">
                    <input type="radio" name="profile" v-model="progress.stepTwo" id="input" value="materials">
                    I need some materials
                </label>
                <label class="btn btn-outline-primary btn-lg w-50" id="btnStepOneSell" for="inputProfileSell">
                    <input type="radio" name="profile" v-model="progress.stepTwo" id="inputProfileSell" value="craft">
                    I need something crafted
                </label>
                <label class="btn btn-outline-primary btn-lg w-50" id="btnStepOneSell" for="inputProfileSell">
                    <input type="radio" name="profile" v-model="progress.stepTwo" id="inputProfileSell" value="craft.enchant">
                    I need some gear enchanted
                </label>
            </div>
        </div>
    </section>

    <section id="marketplaceAction" class="my-5" v-if="progress.stepOne == 'sell'">
        <h3 class="h4 mb-3">What would you like to sell?</h3>
        <div class="row">

        </div>
    </section>
</div>
</template>

<script>
export default {
    data: function () {
        return {
            progress: {
                stepOne: null,
                stepTwo: null,
            },
        }
    },

    methods: {

    },

    watch: {
        stepOne: function (value) {
            this.$el.querySelectorAll('.btn-group.btn-group-toggle label.btn').forEach(function (el) {
                el.classList.remove('active')
            })

            value = value.charAt(0).toUpperCase() + value.slice(1);
            this.$el.querySelector('#btnStepOne' + value).classList.add('active');
        }
    }
}
</script>
