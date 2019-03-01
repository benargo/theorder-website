<template>
    <div class="container">
        <div class="row">
            <table class="table my-4">
                <thead>
                    <tr>
                        <th scope="col">{{ lang.tableHeaders.title }}</th>
                        <th scope="col">{{ lang.tableHeaders.author }}</th>
                        <th scope="col">{{ lang.tableHeaders.publishedAt }}</th>
                        <th scope="col">{{ lang.tableHeaders.updatedAt }}</th>
                        <th scope="col">{{ lang.tableHeaders.actions }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in items" :data-article-id="item.article_id" :data-draft-id="item.draft_id" :class="isDraftClass(index)">
                        <th scope="row">
                            {{ item.title }}
                            <span class="badge badge-primary" v-show="item.draft_id" data-toggle="tooltip" data-placement="top" :title="lang.tooltips.draft">{{ lang.draft }}</span>
                            <span class="badge badge-info" v-show="isScheduledForLater(item.published_at)"  data-toggle="tooltip" data-placement="top" :title="lang.tooltips.scheduled">{{ lang.scheduled }}</span>
                        </th>
                        <td>{{ item.author_battletag }}</td>
                        <td>{{ (item.published_at ? item.published_at : lang.notPublished) }}</td>
                        <td>{{ item.updated_at }}</td>
                        <td>
                            <a :href="item.edit_url" class="btn btn-primary" role="button" data-toggle="tooltip" data-placement="top" :title="lang.buttons.edit">
                                <font-awesome-icon :icon="['fas', 'pencil']" class="fa-sm"></font-awesome-icon>
                                <span class="sr-only">{{ lang.buttons.edit }}</span>
                            </a>
                            <button type="button" class="btn btn-danger" @click="showDeleteModal(index)" data-toggle="tooltip" data-placement="top" :title="lang.buttons.delete">
                                <font-awesome-icon :icon="['fas', 'trash']" class="fa-sm"></font-awesome-icon>
                                <span class="sr-only">{{ lang.buttons.delete }}</span>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row" v-if="last_page > 1">
            <div class="col-12 text-center">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary btn-lg btn-pagination" @click="fetchItems(prev_page_url)" :disabled="(prev_page_url === null)">
                        {{ lang.buttons.previous }}
                    </button>
                    <button
                        class="btn btn-primary btn-lg"
                        :class="(page == current_page ? 'active' : '')"
                        :aria-pressed="(page == current_page)"
                        @click="fetchItems(path + '?page=' + page)"
                        v-for="page in last_page">{{ page }}</button>
                    <button type="button" class="btn btn-primary btn-lg btn-pagination" @click="fetchItems(next_page_url)" :disabled="(next_page_url === null)">
                        {{ lang.buttons.next }}
                    </button>
                </div>
            </div>
        </div>
        <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ lang.modal.header }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p v-if="itemToDelete.draftId">{{ lang.modal.body.draft }}</p>
                        <p v-else>{{ lang.modal.body.item }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">{{ lang.buttons.cancel }}</button>
                        <button type="button" class="btn btn-primary" v-show="! itemToDelete.draftId" @click="unpublishItem(itemToDelete.index)">{{ lang.buttons.unpublish }}</button>
                        <button type="button" class="btn btn-primary" v-if="itemToDelete.draftId" @click="deleteDraft(itemToDelete.index)">{{ lang.buttons.deleteDraft }}</button>
                        <button type="button" class="btn btn-danger" v-else @click="deleteItem(itemToDelete.index)">{{ lang.buttons.deleteItem }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        computed: {
            //
        },
        data: function () {
            return {
                // mounted axios response...
                current_page: undefined,
                items: [],
                first_page_url: undefined,
                from: undefined,
                last_page: undefined,
                last_page_url: undefined,
                next_page_url: undefined,
                path: '/api/news/manager',
                per_page: 20,
                prev_page_url: undefined,
                to: undefined,
                total: 0,

                // other data objects
                itemToDelete: {
                    index: undefined,
                    draftId: undefined,
                    itemId: undefined,
                },
            }
        },
        methods: {
            /**
             * Delete the draft from the database.
             *
             * @param {Number} index
             */
            deleteDraft: function (index) {
                let item = this.items[index]

                if (item) {
                    let path = '/api/news/drafts/' + item.draft_id

                    axios.delete(path)
                         .then(function (response) {
                             // Refresh the list...
                             this.fetchItems(this.path + '?page=' + this.current_page)

                             // Hide the modal...
                             $('#confirmDeleteModal').modal('hide')
                         }.bind(this))
                }
            },

            /**
             * Delete the item from the database.
             *
             * @param {Number} index
             */
            deleteItem: function (index) {
                let item = this.items[index]

                if (item) {
                    let path = '/api/news/' + item.news_item_id

                    axios.delete(path)
                         .then(function (response) {
                             // Refresh the list...
                             this.fetchItems(this.path + '?page=' + this.current_page)

                             // Hide the modal...
                             $('#confirmDeleteModal').modal('hide')
                         }.bind(this, item))
                }
            },

            /**
             * Fetch news items and drafts from the database.
             */
            fetchItems: function (from) {
                axios.get(from)
                     .then(function (response) {
                         this.current_page = response.data.current_page
                         this.items = response.data.data
                         this.first_page_url = response.data.first_page_url
                         this.from = response.data.from
                         this.last_page = response.data.last_page
                         this.last_page_url = response.data.last_page_url
                         this.next_page_url = response.data.next_page_url
                         this.path = response.data.path
                         this.per_page = response.data.per_page
                         this.prev_page_url = response.data.prev_page_url
                         this.to = response.data.to
                         this.total = response.data.total
                     }.bind(this))
            },

            /**
             * Determine whether or not the item at the given index has a draft
             * attached.
             *
             * @param {Number} index
             */
            isDraftClass: function (index) {
                return (!! this.items[index].draft_id
                        && ! this.items[index].news_item_id
                    ? 'is-draft bg-secondary'
                    : ''
                )
            },

            isScheduledForLater: function (date) {
                let now = window.moment().tz('Europe/London')
                    date = (date ? moment(date) : undefined)

                return (date > now)
            },

            /**
             * Show the modal to confirm deletion of the draft/item.
             *
             * @param {Number} indexOfItem
             */
            showDeleteModal: function (indexOfItem) {
                this.itemToDelete = {
                    index: indexOfItem,
                    draftId: this.items[indexOfItem].draft_id,
                }

                $('#confirmDeleteModal').modal()
            },

            /**
             * Unpublish the item.
             *
             * This follows the same format as publishArticle above but instead
             * leaves the date field deliberately blank.
             *
             * @param {Number} news_item_id
             */
            unpublishItem: function (index) {
                let item = this.items[index]

                if (item) {
                    let path = '/api/news/' + item.news_item_id

                    axios.put(path, {publishDate: null})
                         .then(function (response) {
                             item.published_at = null

                             // Refresh the list...
                             this.fetchItems(this.path + '?page=' + this.current_page)

                             // Hide the modal...
                             $('#confirmDeleteModal').modal('hide')
                         }.bind(this, item))
                }
            },
        },
        mounted: function () {
            this.fetchItems(this.path)

            // Initialise tooltips...
            $('[data-toggle="tooltip"]').tooltip()
        },
        props: {
            lang: {
                type: Object,
                required: true,
            },
        },
    }
</script>
