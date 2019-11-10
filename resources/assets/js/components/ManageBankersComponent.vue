<template>
<section id="manageBankersComponent">
    <div class="row">
        <div class="col">
            <table class="table" id="tableBankers">
                <thead>
                    <tr>
                        <th scope="col" colspan="3">Name</th>
                    </tr>
                </thead>
                <draggable v-model="bankers" tag="tbody" @start="drag=true" @end="drag=false" @change="updateOrder">
                    <tr v-for="(b,i) in bankers">
                        <td class="w-100">{{ b.name }}</td>
                        <td class="text-center">
                            <button class="btn btn-primary" role="button" @click="deleteBanker(i)">
                                <font-awesome-icon :icon="['far', 'trash-alt']"></font-awesome-icon>
                                <span class="sr-only">Delete</span>
                            </button>
                        </td>
                        <td class="text-center">
                            <font-awesome-icon :icon="['fas', 'sort']"></font-awesome-icon>
                            <span class="sr-only">Reposition</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="w-100 pl-0" colspan="2">
                            <input type="text"
                                   class="form-control"
                                   id="inputName"
                                   maxlength="12"
                                   name="inputName"
                                   placeholder="Add a new banker..."
                                   v-model="create.name"
                                   @blur="createNewBanker()" />
                        </td>
                        <td class="text-center">
                            <font-awesome-icon :icon="['fas', 'sort']"></font-awesome-icon>
                            <span class="sr-only">Reposition</span>
                        </td>
                    </tr>
                </draggable>
            </table>
        </div>
    </div>
</section>
</template>

<script>
export default {
    data: function() {
        return {
            bankers: [],
            create: {
                name: undefined,
            },
        }
    },

    methods: {
        createNewBanker: function () {
            if (this.create.name.length > 0) {
                // Add the new banker to the end of the array...
                this.bankers.push(this.create);

                // Update the list of bankers, this will include the new banker
                // that has been defined...
                this.updateOrder()

                // Reset the create property back to it's original, blank state...
                this.create = {
                    name: undefined,
                }
            }
        },

        deleteBanker: function (index) {
            // Find the banker in the list of bankers...
            let banker = this.bankers[index]

            // Check that we found a real banker...
            if (banker.name.length > 0) {
                axios.delete('/api/guild-bank/bankers/' + banker.id)
                .then(function (response) {
                    this.getBankers()
                }.bind(this))
                .catch(error => {
                    //
                    // TODO: create reasonable error alert...
                    //
                })
            }
        },

        getBankers: function () {
            axios.get('/api/guild-bank/bankers')
            .then(function (response) {
                this.bankers = response.data.bankers
            }.bind(this))
            .catch(error => {
                //
                // TODO: create reasonable error alert...
                //
            })
        },

        updateOrder: function (e = {}) {
            axios.post('/api/guild-bank/bankers', {
                bankers: this.bankers,
            })
            .then(function (response) {
                this.bankers = response.data.bankers
            }.bind(this))
            .catch(error => {
                //
                // TODO: create reasonable error alert...
                //
            })
        },
    },

    mounted: function() {
        this.getBankers()
    }
}
</script>
