<template>
<div class="container my-6">

    <!-- Step 1: Action  -->
    <section id="bankAction" class="my-6">
        <p class="lead mb-4">Welcome to The Order's guild bank. How can we serve you today?</p>
        <div class="row">
            <div class="col btn-group btn-group-toggle">
                <label class="btn btn-outline-primary btn-lg w-50 py-5" id="btnStepOneSearch" for="inputStepOneSearch">
                    <input type="radio" name="stepOne" v-model="progress.stepOne" id="inputStepOneSearch" value="search">
                    I'm looking for an item...
                </label>
                <label class="btn btn-outline-primary btn-lg w-50 py-5" id="btnStepOneDonate" for="inputStepOneDonate">
                    <input type="radio" name="stepOne" v-model="progress.stepOne" id="inputStepOneDonate" value="donate">
                    I want to donate items...
                </label>
            </div>
        </div>
    </section>

    <section id="bankDonate" class="my-6" v-if="progress.stepOne == 'donate'">
        <p class="lead mb-4">Since guild banks weren't an official thing until The Burning Crusade&trade;, we have to do things the Classic way. The guild bank is spread over nine different characters on a separate WoW account owned and operated by the Inner Circle.</p>
    </section>

    <form id="formFilters" class="my-6" v-if="progress.stepOne == 'search'">
        <div class="row mb-3">
            <div class="col">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text h4" for="inputSearch">Search</label>
                    </div>
                    <input type="text" class="form-control" placeholder="Hearthstone" name="inputSearch" id="inputSearch" />
                    <div class="input-group-append">
                        <button class="btn btn-outline-primary" type="button" id="buttonSearch">
                            <font-awesome-icon :icon="['far', 'search']"></font-awesome-icon>
                            <span class="sr-only">Search</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row my-3">
            <div class="col">
                <div class="card mb-3">
                    <div class="card-header">
                        <h2 class="h4 my-2">Filters</h2>
                    </div>
                    <div class="card-body form-row">
                        <div class="col">
                            <div class="form-group">
                                <label for="inputItemClass">Category</label>
                                <select class="form-control" name="inputItemClass" id="inputItemClass" v-model="filters.itemClass">
                                    <option value="NULL">--</option>
                                    <option value="">Container</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="inputItemSubclass">Subcategory</label>
                                <select class="form-control" name="inputItemSubclass" id="inputItemSubclass" v-model="filters.itemSubclass" disabled>
                                    <option value="NULL">--</option>
                                    <option value="">Container</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="inputRarity">Quality</label>
                                <select class="form-control" name="inputQuality" id="inputQuality" v-model="filters.quality">
                                    <option value="NULL" data-text-class="text-muted">--</option>
                                    <option value="0" data-text-class="text-poor">Poor</option>
                                    <option value="1" data-text-class="text-common">Common</option>
                                    <option value="2" data-text-class="text-uncommon">Uncommon</option>
                                    <option value="3" data-text-class="text-rare">Rare</option>
                                    <option value="4" data-text-class="text-epic">Epic</option>
                                    <option value="5" data-text-class="text-legendary">Legendary</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="my-3" v-for="(banker,name) in items">
        <a :name="name"></a>
        <h2>{{ name }}</h2>
        <div class="row" v-for="(bag,bag_number) in banker">
            <div class="col-12 text-danger" role="alert"><strong>DEBUG</strong>: Bag number {{ bag_number }}</div>
            <div class="col col-lg-3 mb-3" v-for="(slot,i) in bag">
                <img :src="getIconUrl(slot.item.icon)" :alt="slot.item.icon" class="guild-bank-icon" />
                <span class="item-count">x{{ slot.count }}</span>
                <a :href="wowheadItemUrl(slot.item.id)" :class="qualityCssClass(slot.item.quality, 'item-name')" target="_blank">[{{ slot.item.name }}]</a>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    data: function () {
        return {
            filters: {
                itemClass: null,
                itemSubclass: null,
                quality: null,
            },
            items: [],
            itemQualities: {
                0: 'poor',
                1: 'common',
                2: 'uncommon',
                3: 'rare',
                4: 'epic',
                5: 'legendary',
            },
            progress: {
                stepOne: null,
                stepTwo: null,
            },
        }
    },

    methods: {
        qualityCssClass: function (id, classes) {
            let prepend = 'text-'

            if (classes) {
                prepend = classes + ' text-'
            }

            return prepend + this.itemQualities[id]
        },

        getIconUrl: function(path) {
            return 'https://render-eu.worldofwarcraft.com/icons/56/' + path + '.jpg';
        },

        wowheadItemUrl: function (id) {
            return "https://classic.wowhead.com/item=" + id
        }
    },

    mounted() {
        axios.get('/api/guild-bank/stock')
            .then(function(response) {
                this.items = response.data
            }.bind(this))
    },
}
</script>
