<template>
<div class="container my-6">

    <!-- Step 1: Action  -->
    <section id="bankAction" class="my-6">
        <p class="lead mb-4">Welcome to The Order's guild bank. How can we serve you today?</p>
        <div class="row">
            <div class="col btn-group btn-group-toggle">
                <label :class="btnStepOneSearchClass" id="btnStepOneSearch" for="inputStepOneSearch">
                    <input type="radio" name="stepOne" v-model="progress.stepOne" id="inputStepOneSearch" value="search">
                    I&rsquo;m looking for an item...
                </label>
                <label :class="btnStepOneDonateClass" id="btnStepOneDonate" for="inputStepOneDonate">
                    <input type="radio" name="stepOne" v-model="progress.stepOne" id="inputStepOneDonate" value="donate">
                    I want to donate items...
                </label>
            </div>
        </div>
    </section>

    <section id="bankDonate" class="my-6" v-if="progress.stepOne == 'donate'">
        <p class="lead mb-4">
            Since guild banks weren't an official thing until The Burning Crusade&trade;, we have to do things the Classic way. The guild bank is spread over nine different characters on a separate WoW account owned and operated by the guild management.
        </p>
        <p class="lead mb-4">
            Below you will find the list of bank characters, so you know where to send each item.
        </p>

        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <b-media>
                    <template v-slot:aside>
                        <wow-icon name="achievement_character_dwarf_female" width="60"></wow-icon>
                    </template>

                    <h5 class="mt-0">Theorder</h5>
                    <p>
                        If you're unsure which character to send a particular item to, and after reviewing the list below, send it to me.
                    </p>
                </b-media>
            </li>

            <li class="list-group-item">
                <b-media>
                    <template v-slot:aside>
                        <wow-icon name="trade_alchemy" width="60"></wow-icon>
                    </template>

                    <h5 class="mt-0">Bezoar</h5>
                    <p>
                        I'm the keeper of raid consumables. I help out with spare consumables when people don&rsquo;t have time to grind.
                    </p>
                    <ul class="list-inline">
                        <li class="list-inline-item">Yes please:</li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'check-circle']"></font-awesome-icon>
                            Flasks
                        </li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'check-circle']"></font-awesome-icon>
                            Elixirs
                        </li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'check-circle']"></font-awesome-icon>
                            Potions
                        </li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'check-circle']"></font-awesome-icon>
                            Other raid consumables
                        </li>
                    </ul>
                    <ul class="list-inline">
                        <li class="list-inline-item">No thanks:</li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'times-circle']"></font-awesome-icon>
                            Buff food
                        </li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'times-circle']"></font-awesome-icon>
                            Herbs
                        </li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'times-circle']"></font-awesome-icon>
                            Alchemy recipes
                        </li>
                    </ul>
                </b-media>
            </li>

            <li class="list-group-item">
                <b-media>
                    <template v-slot:aside>
                        <wow-icon name="inv_fabric_purplefire_01" width="60"></wow-icon>
                    </template>

                    <h5 class="mt-0">Garment</h5>
                    <p>
                        I&rsquo;m the collector of cloth, and other items needed by tailors.
                    </p>
                    <ul class="list-inline">
                        <li class="list-inline-item">Yes please:</li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'check-circle']"></font-awesome-icon>
                            Raw cloth
                        </li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'check-circle']"></font-awesome-icon>
                            Bolts of cloth
                        </li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'check-circle']"></font-awesome-icon>
                            Spiders&rsquo; silk
                        </li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'check-circle']"></font-awesome-icon>
                            Tailored gear
                        </li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'check-circle']"></font-awesome-icon>
                            Bags
                        </li>
                    </ul>
                    <ul class="list-inline">
                        <li class="list-inline-item">No thanks:</li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'times-circle']"></font-awesome-icon>
                            Tailoring patterns
                        </li>
                    </ul>
                </b-media>
            </li>

            <li class="list-group-item">
                <b-media>
                    <template v-slot:aside>
                        <wow-icon name="inv_misc_flower_02" width="60"></wow-icon>
                    </template>

                    <h5 class="mt-0">Herbivore</h5>
                    <p>
                        I like to think of myself as the CEO of your local garden center!
                    </p>
                    <ul class="list-inline">
                        <li class="list-inline-item">Yes please:</li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'check-circle']"></font-awesome-icon>
                            Herbs
                        </li>
                    </ul>
                    <ul class="list-inline">
                        <li class="list-inline-item">No thanks:</li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'times-circle']"></font-awesome-icon>
                            Flasks
                        </li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'times-circle']"></font-awesome-icon>
                            Elixirs
                        </li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'times-circle']"></font-awesome-icon>
                            Potions
                        </li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'times-circle']"></font-awesome-icon>
                            Alchemy recipes
                        </li>
                    </ul>
                </b-media>
            </li>

            <li class="list-group-item">
                <b-media>
                    <template v-slot:aside>
                        <wow-icon name="inv_misc_food_15" width="60"></wow-icon>
                    </template>

                    <h5 class="mt-0">Mealonwheels</h5>
                    <p>
                        I might <em>look</em> like a gnome, but I see myself as a giant fridge-freezer combo.
                    </p>
                    <ul class="list-inline">
                        <li class="list-inline-item">Yes please:</li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'check-circle']"></font-awesome-icon>
                            Buff food
                        </li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'check-circle']"></font-awesome-icon>
                            Raw meat
                        </li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'check-circle']"></font-awesome-icon>
                            Raw fish
                        </li>
                    </ul>
                    <ul class="list-inline">
                        <li class="list-inline-item">No thanks:</li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'times-circle']"></font-awesome-icon>
                            Cooking recipes
                        </li>
                    </ul>
                </b-media>
            </li>

            <li class="list-group-item">
                <b-media>
                    <template v-slot:aside>
                        <wow-icon name="inv_ingot_06" width="60"></wow-icon>
                    </template>

                    <h5 class="mt-0">Mithril</h5>
                    <p>
                        <em>
                            <font-awesome-icon :icon="['fas', 'music-alt']"></font-awesome-icon>
                            I am a dwarf and I'm digging a hole...
                            <font-awesome-icon :icon="['fas', 'music-alt']"></font-awesome-icon>
                        </em>
                        Oh sorry, yes I&rsquo;m in charge of anything used by blacksmiths and engineers!
                    </p>
                    <ul class="list-inline">
                        <li class="list-inline-item">Yes please:</li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'check-circle']"></font-awesome-icon>
                            Metal ore
                        </li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'check-circle']"></font-awesome-icon>
                            Metal bars
                        </li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'check-circle']"></font-awesome-icon>
                            Blacksmithing components
                        </li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'check-circle']"></font-awesome-icon>
                            Engineering components
                        </li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'check-circle']"></font-awesome-icon>
                            Crafted gear and weapons
                        </li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'check-circle']"></font-awesome-icon>
                            Bombs and dynamite
                        </li>
                    </ul>
                    <ul class="list-inline">
                        <li class="list-inline-item">No thanks:</li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'times-circle']"></font-awesome-icon>
                            Blacksmithing plans
                        </li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'times-circle']"></font-awesome-icon>
                            Engineering schematics
                        </li>
                    </ul>
                </b-media>
            </li>

            <li class="list-group-item">
                <b-media>
                    <template v-slot:aside>
                        <wow-icon name="inv_enchant_shardbrilliantlarge" width="60"></wow-icon>
                    </template>

                    <h5 class="mt-0">Shards</h5>
                    <p>
                        I collect dust, magical essences and shiny things.
                    </p>
                    <ul class="list-inline">
                        <li class="list-inline-item">Yes please:</li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'check-circle']"></font-awesome-icon>
                            Dust
                        </li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'check-circle']"></font-awesome-icon>
                            Lesser Magic Essences
                        </li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'check-circle']"></font-awesome-icon>
                            Greater Magic Essences
                        </li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'check-circle']"></font-awesome-icon>
                            Shards
                        </li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'check-circle']"></font-awesome-icon>
                            Nexus Crystals
                        </li>
                    </ul>
                    <ul class="list-inline">
                        <li class="list-inline-item">No thanks:</li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'times-circle']"></font-awesome-icon>
                            Enchanting formulae
                        </li>
                    </ul>
                </b-media>
            </li>

            <li class="list-group-item">
                <b-media>
                    <template v-slot:aside>
                        <wow-icon name="inv_misc_armorkit_17" width="60"></wow-icon>
                    </template>

                    <h5 class="mt-0">Skinsaw</h5>
                    <p>
                        I may have leathery skin, but I&rsquo;m much more friendly than my name would suggest!
                    </p>
                    <ul class="list-inline">
                        <li class="list-inline-item">Yes please:</li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'check-circle']"></font-awesome-icon>
                            Leather
                        </li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'check-circle']"></font-awesome-icon>
                            Raw hides
                        </li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'check-circle']"></font-awesome-icon>
                            Cured hides
                        </li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'check-circle']"></font-awesome-icon>
                            Deeprock salt
                        </li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'check-circle']"></font-awesome-icon>
                            Other leatherworking components
                        </li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'check-circle']"></font-awesome-icon>
                            Crafted gear
                        </li>

                    </ul>
                    <ul class="list-inline">
                        <li class="list-inline-item">No thanks:</li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'times-circle']"></font-awesome-icon>
                            Leatherworking patterns
                        </li>
                    </ul>
                </b-media>
            </li>

            <li class="list-group-item">
                <b-media>
                    <template v-slot:aside>
                        <wow-icon name="inv_scroll_03" width="60"></wow-icon>
                    </template>

                    <h5 class="mt-0">Patterns</h5>
                    <p>
                        I'd make a good bureaucrat, since I seem to be drowing in pieces of paper...
                    </p>
                    <ul class="list-inline">
                        <li class="list-inline-item">Yes please:</li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'check-circle']"></font-awesome-icon>
                            Alchemy recipes
                        </li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'check-circle']"></font-awesome-icon>
                            Blacksmithing plans
                        </li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'check-circle']"></font-awesome-icon>
                            Cooking recipes
                        </li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'check-circle']"></font-awesome-icon>
                            Enchanting formulae
                        </li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'check-circle']"></font-awesome-icon>
                            Engineering schematics
                        </li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'check-circle']"></font-awesome-icon>
                            Leatherworking patterns
                        </li>
                        <li class="list-inline-item">
                            <font-awesome-icon :icon="['fas', 'check-circle']"></font-awesome-icon>
                            Tailoring patterns
                        </li>
                    </ul>
                </b-media>
            </li>
        </ul>
    </section>

    <section id="bankSearch" class="my-6" v-if="progress.stepOne == 'search'">
        <form id="formFilters">
            <div class="card my-3">
                <div class="card-header">
                    <h2 class="h4 my-2">Filters</h2>
                </div>
                <div class="card-body">
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
                    <div class="row mb-3">
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
    </section>
</div>
</template>

<script>
export default {

    computed: {
        btnStepOneSearchClass: function () {
            let cssClass = 'btn btn-lg w-50 py-5'

            this.progress.stepOne == 'search'
                ? cssClass += ' btn-primary'
                : cssClass += ' btn-outline-primary'

            return cssClass
        },

        btnStepOneDonateClass: function () {
            let cssClass = 'btn btn-lg w-50 py-5'

            this.progress.stepOne == 'donate'
                ? cssClass += ' btn-primary'
                : cssClass += ' btn-outline-primary'

            return cssClass
        }
    },

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

        getIconUrl: function (path) {
            return 'https://render-eu.worldofwarcraft.com/icons/56/' + path + '.jpg';
        },

        wowheadItemUrl: function (id) {
            return "https://classic.wowhead.com/item=" + id
        }
    },

    mounted: function () {
        axios.get('/api/guild-bank/stock')
            .then(function(response) {
                this.items = response.data
            }.bind(this))
    },
}
</script>
