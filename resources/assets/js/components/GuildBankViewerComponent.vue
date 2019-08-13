<template>
<div class="container py-6">
    <form id="formFilters">
        <div class="row">
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
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h2 class="h4 my-2">Filters</h2>
                    </div>
                    <div class="card-body form-row">
                        <div class="col">
                            <div class="form-group">
                                <label for="inputItemClass">Category</label>
                                <select class="form-control" name="inputItemClass" id="inputItemClass">
                                    <option value="NULL">--</option>
                                    <option value="">Container</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="inputItemSubclass">Subcategory</label>
                                <select class="form-control" name="inputItemSubclass" id="inputItemSubclass" disabled>
                                    <option value="NULL">--</option>
                                    <option value="">Container</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="inputRarity">Rarity</label>
                                <select class="form-control" name="inputRarity" id="inputRarity">
                                    <option value="NULL" data-text-class="text-muted">--</option>
                                    <option value="POOR" data-text-class="text-poor">Poor</option>
                                    <option value="COMMON" data-text-class="text-common">Common</option>
                                    <option value="UNCOMMON" data-text-class="text-uncommon">Uncommon</option>
                                    <option value="RARE" data-text-class="text-rare">Rare</option>
                                    <option value="EPIC" data-text-class="text-epic">Epic</option>
                                    <option value="LEGENDARY" data-text-class="text-legendary">Legendary</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
</template>

<script>
export default {
    mounted() {
        console.log('Component mounted.')
    }
}
</script>
