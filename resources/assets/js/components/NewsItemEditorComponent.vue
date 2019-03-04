<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-9 editor">
                <div class="row">
                    <div class="col">
                        <h2 contenteditable="true" id="titleEditable" class="news-editor-title" @focus.once="highlight()" @blur="trimTitle()" @input="filterEditable()">{{ (startingTitle ? startingTitle : lang.startingTitle) }}</h2>
                    </div>
                </div>
                <div class="row no-gutters">
                    <textarea :value="article.body" @input="processMarkdown" :placeholder="lang.placeholder" class="col md-editor text-light"></textarea>
                    <div v-html="compiledMarkdown" class="col md-compiled d-none d-md-block"></div>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <h2>Settings</h2>
                <div class="card my-4">
                    <div class="card-body">
                        <h5 class="card-title">{{ lang.author }}</h5>
                        <div class="form-group">
                            <label for="selectAuthor">{{ lang.selectAuthor }}</label>
                            <select id="selectAuthor" class="form-control" v-model="authorId">
                                <option v-for="author in authors" :value="author.id" :label="getBattletag(author.battletag)" :selected="authorIsUser(author.id)" />
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">{{ lang.url }}</h5>
                        <form class="needs-validation" id="articleUrlForm" novalidate>
                            <div class="form-group">
                                <label for="articleUrl">{{ lang.labelUrl }}</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            {{ lang.basePath }}/
                                        </span>
                                    </div>
                                    <input class="form-control" id="articleUrl" v-model="article.url" @change="validateCustomUrl()" @input="setCustomUrl()">
                                    <div class="valid-feedback text-lg-right">
                                        <font-awesome-icon :icon="['fas', 'check-circle']"></font-awesome-icon>
                                        {{ lang.urlIsAvailable }}
                                    </div>
                                    <div class="invalid-feedback text-lg-right">
                                        <font-awesome-icon :icon="['fas', 'times-circle']"></font-awesome-icon>
                                        {{ lang.urlNotAvailable }}
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">{{ lang.comments }}</h5>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="allowComments" v-model="allowComments" />
                            <label class="form-check-label" for="allowComments">{{ lang.allowComments }}</label>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">{{ lang.publishingOptions }}</h5>
                        <div class="alert alert-danger fade show d-none" id="errPublishing" role="alert">
                            <p>{{ lang.errPublishing }}</p>
                        </div>
                        <div class="form-group" v-if="publishDate <= new Date()">
                            <p>{{ lang.currentlyPublished }}</p>
                            <p><button class="button btn btn-danger" @click="unpublishArticle()">{{ lang.unpublishButton }}</button></p>
                        </div>
                        <div class="form-group" v-else>
                            <p>{{ lang.notCurrentlyPublished }}</p>
                            <div class="btn-group" id="btnPublish">
                                <button type="button" class="btn btn-primary" @click="publishArticle()">{{ lang.publishNowButton }}</button>
                                <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="sr-only">{{ lang.togglePublishingOptions }}</span>
                                </button>
                                <div class="dropdown-menu">
                                    <a href="#" class="dropdown-item" role="button" data-toggle="modal" data-target="#publishDateModal">{{ lang.publishLaterButton }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-4" v-if="article.id">
                    <div class="input-group-prepend">
                        <span class="input-group-text">{{ lang.articleId }}</span>
                    </div>
                    <input class="form-control" id="articleId" :value="article.id" disabled>
                    <div class="input-group-append">
                        <a class="btn btn-outline-primary" :href="viewArticleUrl" role="button" target="_blank">{{ lang.viewArticle }}</a>
                    </div>
                </div>
                <div class="input-group mb-4" v-if="draft.id">
                    <div class="input-group-prepend">
                        <span class="input-group-text">{{ lang.draftId }}</span>
                    </div>
                    <input class="form-control" id="draftId" :value="draft.id" disabled>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="publishDateModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ lang.publishLaterButton }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="needs-validation" id="formPublishDate" novalidate>
                            <div class="form-group">
                                <label for="publishDate">{{ lang.labelPublishDate }}</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <font-awesome-icon :icon="['far', 'calendar']"></font-awesome-icon>
                                        </span>
                                    </div>
                                    <input type="text"
                                           class="form-control"
                                           id="inputPublishDate"
                                           v-mask="'99/99/9999 99:99'"
                                           v-model="publishDate"
                                           aria-describedby="publishDateHelp"
                                           placeholder="__/__/____ __:__"
                                           @blur="validatePublishDate">
                                    <div class="invalid-feedback">
                                        {{ lang.errInvalidPublishDate }}
                                    </div>
                                </div>
                                <small id="publishDateHelp" class="form-text text-muted">{{ lang.labelPublishDateHelp }}</small>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="publishArticle()">{{ lang.publishLaterButton }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        computed: {
            compiledMarkdown: function () {
                return window.marked(this.article.body, { sanitize: true })
            },

            viewArticleUrl: function () {
                return '/news/' + this.article.url
            }
        },

        data: function () {
            return {
                allowComments: false,
                article: {
                    id: this._props.articleId ? this._props.articleId : null,
                    title: null,
                    body: '',
                    url: null,
                },
                authorId: this._props.user.id,
                customUrl: false,
                draft: {
                    id: this._props.draftId ? this._props.draftId : null,
                    title: null,
                    body: null,
                },
                publishDate: undefined,
                startingTitle: undefined,
            }
        },

        methods: {
            /**
             * Performs a simple check to determine whether the given author
             * is the current user.
             *
             * @param  {Number}  author_id
             * @return {Boolean}
             */
            authorIsUser: function (author_id) {
                return (author_id === this.user.id)
            },

            /**
             * Take a look at the title and filter out any HTML so it's solely
             * plain text.
             */
            filterEditable: function () {
                var cell = this.$el.querySelector('#titleEditable').innerHTML

                // Convert any non-breaking spaces to regular spaces, and
                // remove any HTML tags...
                cell = cell.replace(/&nbsp;/g, ' ')
                cell = cell.replace(/(<([^>]+)>)/g, '')

                // Set the title to the filtered input...
                this.article.title = cell

                // Sets the default URL if there is none...
                if (! this.customUrl && this.article.title) {
                    this.article.url = this.filterUrl(this.article.title)
                }
            },

            /**
             * Removes unwanted characters from a URL.
             *
             * @param  {String} url
             * @return {String}
             */
            filterUrl: function (url) {
                var filteredUrl = null

                if (url) {
                    filteredUrl = str_slug(url)
                    filteredUrl = filteredUrl.replace(/&nbsp;|\s+$/g, '')
                    filteredUrl = filteredUrl.replace(/(&([^;]+);)/g, '')
                    filteredUrl = filteredUrl.replace(/[-]{2,}/g, '-')
                    filteredUrl = filteredUrl.replace(/[^-\w\d\s]+/g, '')
                }

                return filteredUrl
            },

            /**
             * Fetches the article from the database.
             *
             * @param  {Number} articleId
             */
            getArticle: function (articleId) {
                axios.get('/api/news/' + articleId)
                     .then(function (response) {
                         this.article.id     = response.data.id
                         this.article.title  = response.data.title
                         this.article.body   = response.data.body
                         this.article.url    = response.data.url
                         this.allowsComments = response.data.allows_comments
                         this.authorId       = response.data.author_id

                         // Change the title...
                         this.startingTitle = this.article.title

                         // Quickly check whether the URL is a custom one or not...
                         this.setCustomUrl()
                     }.bind(this))
                     .catch(function (error) {

                     })
            },

            /**
             * Returns just the elected portion of the Battletag.
             *
             * @param  {String} battletag
             * @return {String}
             */
            getBattletag: function (battletag) {
                return battletag.substr(0, battletag.indexOf('#'))
            },

            /**
             * Highlight the full content of the title bar when it is clicked
             * on.
             */
            highlight: function () {
                var cell = this.$el.querySelector('#titleEditable')
                var range, selection

                if (document.body.createTextRange) {
                    range = document.body.createTextRange()
                    range.moveToElementText(cell)
                    range.select()
                } else if (window.getSelection) {
                    selection = window.getSelection()
                    range = document.createRange()
                    range.selectNodeContents(cell)
                    selection.removeAllRanges()
                    selection.addRange(range)
                }
            },

            processMarkdown: _.debounce(function (e) {
                this.article.body = e.target.value
            }, 100),

            /**
             * Publish the article at the specified time.
             */
            publishArticle: function () {
                let component = this
                let publishDate

                if (this.publishDate) {
                    publishDate = window.moment(this.publishDate, 'DD/MM/YYYY HH:mm')
                }

                // Build an object of the data we are going to send...
                let data = {
                    allowsComments: this.allowComments,
                    author: this.authorId,
                    body: this.article.body,
                    draftId: this.draft.id,
                    publishDate: (publishDate instanceof window.moment
                        ? publishDate.toISOString()
                        : window.moment().toISOString()),
                    title: this.article.title,
                    url: this.article.url,
                }

                // Decide whether we are going to create a new article or
                // update an existing article...
                if (this.article.id) {
                    let path = '/api/news/' + this.article.id

                    axios.put(path, data)
                         .then(function (response) {
                             this.publishDate = new Date(response.data.published_at)
                         }.bind(this))
                         .catch(this.showPublishingError)
                }
                else {
                    axios.post('/api/news/create', data)
                         .then(function (response) {
                            this.article.id = response.data.id
                            this.publishDate = new Date(response.data.published_at)
                         }.bind(this))
                         .catch(this.showPublishingError)
                }

                // Close the modal (if it is already open...)
                $('#publishDateModal').modal('hide')
            },

            /**
             * Saves the current draft to the database.
             */
            saveDraft: function () {
                if (this.draft.id) {
                    let path = '/api/news/drafts/' + this.draft.id

                    axios.put(path, {
                        title: this.article.title,
                        body: this.article.body,
                    })
                }
            },

            /**
             * Ensures the custom URL set is in a correct slug format before
             * being set.
             */
            setCustomUrl: function () {
                this.article.url = this.filterUrl(this.article.url)

                if (this.article.title) {
                    let defaultUrl = str_slug(this.article.title)

                    if (this.article.url !== defaultUrl) {
                        this.customUrl = true
                    }
                    else {
                        this.customUrl = false
                    }

                }
                else if (this.article.url) {
                    this.customUrl = true
                }
                else {
                    this.customUrl = false
                }
            },

            /**
             * Shows the alert box that there is an error when performing the
             * AJAX request to publish the news article.
             *
             * @param {Object} error
             */
            showPublishingError: function (error) {
                // Show the error alert...
                $('#errPublishing').removeClass('d-none').show()

                // Hide the alert after 10 seconds...
                window.setTimeout(function () {
                    $('#errPublishing').alert('close')
                }, 10000)
            },

            /**
             * Trim any excess space from the article title.
             */
            trimTitle: function () {
                if (typeof this.article.title.toString === 'undefined') {
                    throw new Error('An error has occured while converting the title to ascii.');
                }

                // Remove any extra spaces from the end of the title...
                this.article.title = this.article.title.replace(/&nbsp;|\s+$/g, '')
            },

            /**
             * Unpublish the article.
             *
             * This follows the same format as publishArticle above but instead
             * leaves the date field deliberately blank.
             */
            unpublishArticle: function () {
                // Build an object of the data we are going to send...
                let component = this;
                let data = {
                    allowsComments: this.allowComments,
                    author: this.authorId,
                    body: this.article.body,
                    publishDate: null,
                    title: this.article.title,
                    url: this.article.url,
                }

                // We only want to do this to an existing article...
                if (this.article.id) {
                    let path = '/api/news/' + this.article.id

                    axios.put(path, data)
                         .then(function (response) {
                             component.publishDate = undefined
                         })
                         .catch(this.showPublishingError)
                }
            },

            /**
             * Check with the database if URL is available.
             *
             * @return {Boolean}
             */
            validateCustomUrl: function () {
                var form = this.$el.querySelector('form#articleUrlForm'),
                    field = this.$el.querySelector('#articleUrl'),
                    urlIsAvailable = false

                form.classList.remove('was-validated')

                if (this.customUrl) {
                    axios.get('/api/news/check-url', {
                        params: {
                            url: this.article.url
                        },
                    })
                    .then(function (response) {
                        urlIsAvailable = response.data.urlIsAvailable
                        form.classList.add('was-validated')

                        urlIsAvailable
                            ? field.setCustomValidity('')
                            : field.setCustomValidity('no')
                    })
                }
            },

            /**
             * Check that the publish date field is valid.
             */
            validatePublishDate: function (field) {
                $('#formPublishDate').addClass('was-validated');

                if (field.target.inputmask.isComplete()) {
                    field.target.setCustomValidity('')
                }
                else {
                    field.target.setCustomValidity('no')
                }
            },
        },

        mounted: function () {
            /**
             * Setup autosaving of drafts
             */
            var component = this,
                poll = window.setInterval(this.saveDraft, 10000),
                hidden, visibilityChange, state

            if (typeof document.hidden !== "undefined") {
                hidden = "hidden"
                visibilityChange = "visibilitychange"
                state = "visibilityState"
            } else if (typeof document.mozHidden !== "undefined") {
                hidden = "mozHidden"
                visibilityChange = "mozvisibilitychange"
                state = "mozVisibilityState"
            } else if (typeof document.msHidden !== "undefined") {
                hidden = "msHidden"
                visibilityChange = "msvisibilitychange"
                state = "msVisibilityState";
            } else if (typeof document.webkitHidden !== "undefined") {
                hidden = "webkitHidden"
                visibilityChange = "webkitvisibilitychange"
                state = "webkitVisibilityState"
            }

            document.addEventListener(visibilityChange, function () {
                if (document[state] == 'visible') {
                    poll = window.setInterval(component.saveDraft, 10000)
                }
                else if (document[state] == 'hidden') {
                    clearInterval(poll)
                }
            })

            window.addEventListener('focus', function () {
                poll = window.setInterval(component.saveDraft, 10000)
            })

            window.addEventListener('blur', function () {
                clearInterval(poll)
            })

            /**
             * Pull down the current article
             */
            if (this.article.id) {
                this.getArticle(this.article.id)
            }
        },

        props: {
            articleId: Number,
            authors: {
                type: Array,
                required: true,
            },
            draftId: Number,
            lang: {
                type: Object,
                required: true,
            },
            user: Object,
        },
    }
</script>
