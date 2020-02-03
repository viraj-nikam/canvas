<template>
    <div v-cloak>
        <div class="position-relative" v-closable="{exclude: ['toggle'],handler: 'handleClicksOutsideEditor'}">
            <div class="sidebar-controls" ref="sidebarControls">
                <button @click="toggleSidebarControls" ref="toggle" class="btn btn-outline-light btn-circle border" type="button">
                    <span v-if="controlIsActive">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" viewBox="0 0 24 24" class="icon-close">
                            <path class="fill-body-color" fill-rule="evenodd" d="M15.78 14.36a1 1 0 0 1-1.42 1.42l-2.82-2.83-2.83 2.83a1 1 0 1 1-1.42-1.42l2.83-2.82L7.3 8.7a1 1 0 0 1 1.42-1.42l2.83 2.83 2.82-2.83a1 1 0 0 1 1.42 1.42l-2.83 2.83 2.83 2.82z"/>
                        </svg>
                    </span>
                    <span v-else>
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" viewBox="0 0 24 24" class="icon-add-circle">
                            <circle cx="12" cy="12" r="10" style="fill:none"/>
                            <path class="fill-body-color" d="M13 11h4a1 1 0 0 1 0 2h-4v4a1 1 0 0 1-2 0v-4H7a1 1 0 0 1 0-2h4V7a1 1 0 0 1 2 0v4z"/>
                        </svg>
                    </span>
                </button>
                <div class="controls pl-3 d-none">
                    <button
                        @click="showImageModal"
                        class="btn btn-outline-light btn-circle border mr-1"
                        type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" viewBox="0 0 24 24" class="icon-camera">
                            <path class="fill-body-color" d="M6.59 6l2.7-2.7A1 1 0 0 1 10 3h4a1 1 0 0 1 .7.3L17.42 6H20a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8c0-1.1.9-2 2-2h2.59zM19 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-7 8a5 5 0 1 0 0-10 5 5 0 0 0 0 10z"/>
                            <path class="fill-body-color" d="M12 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                        </svg>
                    </button>
                    <button
                        @click="showEmbedVideoModal"
                        class="btn btn-outline-light btn-circle border mr-1"
                        type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" viewBox="0 0 24 24" class="icon-play">
                            <circle cx="12" cy="12" r="10" class="fill-body-color"/>
                            <path class="fill-bg" d="M15.51 11.14a1 1 0 0 1 0 1.72l-5 3A1 1 0 0 1 9 15V9a1 1 0 0 1 1.51-.86l5 3z"/>
                        </svg>
                    </button>
                    <button
                        @click="showEmbedLinkModal"
                        class="btn btn-outline-light btn-circle border mr-1"
                        type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" viewBox="0 0 24 24" class="icon-code">
                            <rect width="18" height="18" x="3" y="3" class="fill-bg" rx="2"/>
                            <path class="fill-body-color" d="M8.7 13.3a1 1 0 0 1-1.4 1.4l-2-2a1 1 0 0 1 0-1.4l2-2a1 1 0 1 1 1.4 1.4L7.42 12l1.3 1.3zm6.6 0l1.29-1.3-1.3-1.3a1 1 0 1 1 1.42-1.4l2 2a1 1 0 0 1 0 1.4l-2 2a1 1 0 0 1-1.42-1.4zm-3.32 3.9a1 1 0 0 1-1.96-.4l2-10a1 1 0 0 1 1.96.4l-2 10z"/>
                        </svg>
                    </button>
                    <button
                        @click="insertDivider"
                        class="btn btn-outline-light btn-circle border mr-2"
                        type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" viewBox="0 0 24 24" class="icon-dots-horizontal">
                            <path class="fill-body-color" fill-rule="evenodd" d="M5 14a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm7 0a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm7 0a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"/>
                        </svg>
                    </button>
                </div>
            </div>

            <div ref="editor" class="mb-5"></div>

            <nav class="navbar fixed-bottom navbar-expand-sm mt-5 d-xl-none p-0 navbar-mini">
                <div class="btn-group d-flex justify-content-center">
                    <button
                        @click="showImageModal"
                        class="btn btn-outline-light border border-bottom-0 border-left-0 py-2"
                        type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" viewBox="0 0 24 24" class="icon-camera">
                            <path class="fill-body-color" d="M6.59 6l2.7-2.7A1 1 0 0 1 10 3h4a1 1 0 0 1 .7.3L17.42 6H20a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8c0-1.1.9-2 2-2h2.59zM19 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-7 8a5 5 0 1 0 0-10 5 5 0 0 0 0 10z"/>
                            <path class="fill-body-color" d="M12 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                        </svg>
                    </button>
                    <button
                        @click="showEmbedVideoModal"
                        class="btn btn-outline-light border border-bottom-0 border-left-0 py-2"
                        type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" viewBox="0 0 24 24" class="icon-play">
                            <circle cx="12" cy="12" r="10" class="fill-body-color"/>
                            <path class="fill-bg" d="M15.51 11.14a1 1 0 0 1 0 1.72l-5 3A1 1 0 0 1 9 15V9a1 1 0 0 1 1.51-.86l5 3z"/>
                        </svg>
                    </button>
                    <button
                        @click="showEmbedLinkModal"
                        class="btn btn-outline-light border border-bottom-0 border-left-0 py-2"
                        type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" viewBox="0 0 24 24" class="icon-code">
                            <rect width="18" height="18" x="3" y="3" class="fill-bg" rx="2"/>
                            <path class="fill-body-color" d="M8.7 13.3a1 1 0 0 1-1.4 1.4l-2-2a1 1 0 0 1 0-1.4l2-2a1 1 0 1 1 1.4 1.4L7.42 12l1.3 1.3zm6.6 0l1.29-1.3-1.3-1.3a1 1 0 1 1 1.42-1.4l2 2a1 1 0 0 1 0 1.4l-2 2a1 1 0 0 1-1.42-1.4zm-3.32 3.9a1 1 0 0 1-1.96-.4l2-10a1 1 0 0 1 1.96.4l-2 10z"/>
                        </svg>
                    </button>
                    <button
                        @click="insertDivider"
                        class="btn btn-outline-light border border-bottom-0 border-right-0 py-2"
                        type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" viewBox="0 0 24 24" class="icon-dots-horizontal">
                            <path class="fill-body-color" fill-rule="evenodd" d="M5 14a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm7 0a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm7 0a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"/>
                        </svg>
                    </button>
                </div>
            </nav>

            <image-modal
                ref="imageModal"
                @addingImage="insertImage"
                @removingImage="removeImage"
            />

            <embed-link-modal
                ref="embedLinkModal"
                @addingEmbeddedLink="insertEmbedLink"
            />

            <embed-video-modal
                ref="embedVideoModal"
                @addingEmbeddedVideo="insertEmbedVideo"
            />
        </div>
    </div>
</template>

<script>
    import _ from 'lodash'
    import $ from 'jquery'
    import Quill from 'quill'
    import {mapState} from 'vuex'
    import Parchment from 'parchment'
    import ImageBlot from './ImageBlot'
    import VideoBlot from './VideoBlot'
    import TweetBlot from './TweetBlot'
    import ImageModal from './ImageModal'
    import DividerBlot from './DividerBlot'
    import EmbedLinkModal from './EmbedLinkModal'
    import EmbedVideoModal from './EmbedVideoModal'
    import Closable from '../../../js/directives/Closable'

    export default {
        name: 'quill-editor',

        props: {
            value: {
                type: String,
                default: '',
            },
        },

        directives: {
            Closable
        },

        components: {
            EmbedLinkModal,
            EmbedVideoModal,
            ImageModal
        },

        data() {
            return {
                editor: null,
                controlIsActive: false,
                trans: JSON.parse(Canvas.lang),
            }
        },

        mounted() {
            this.editor = this.createEditor()

            this.handleEditorValue()

            // Render any Tweets inside the editor
            let tweets = document.querySelectorAll('div.ql-tweet')
            for (let i = 0; i <tweets.length; i++) {
                while (tweets[i].firstChild) {
                    tweets[i].removeChild(tweets[i].firstChild)
                }

                twttr.widgets.createTweet(tweets[i].dataset.id, tweets[i], {
                    theme: !Canvas.darkMode ? 'light': 'dark'
                })
            }

            this.handleClicksInsideEditor()
            this.initSideControls()
        },

        computed: mapState(['activePost']),

        watch: {
            'activePost.body'(val) {
                this.update()
            },
        },

        methods: {
            createEditor() {
                Quill.register(ImageBlot, true)
                Quill.register(DividerBlot, true)
                Quill.register(TweetBlot, true)
                Quill.register(VideoBlot, true)

                const icons = Quill.import('ui/icons')
                icons.header[3] = require('!html-loader!quill/assets/icons/header-3.svg')

                let quill = new Quill(this.$refs.editor, {
                    modules: {
                        syntax: true,
                        toolbar: [
                            ['bold', 'italic', 'code', 'link'],
                            [{header: '2'}, {header: '3'}],
                            ['blockquote', 'code-block'],
                        ],
                    },
                    theme: 'bubble',
                    scrollingContainer: 'html, body',
                    placeholder: this.trans.posts.forms.editor.body,
                })

                /**
                 * Temporary workaround for customizing the link tooltip.
                 *
                 * @link https://github.com/quilljs/quill/issues/1107#issuecomment-259938173
                 */
                let tooltip = quill.theme.tooltip
                let input = tooltip.root.querySelector('input[data-link]')

                input.dataset.link = this.trans.posts.forms.editor.link

                return quill
            },

            handleEditorValue() {
                this.editor.root.innerHTML = this.$store.getters.activePost.body

                this.editor.on('text-change', (delta, oldContents, source) => {
                    this.controlIsActive = false
                    this.$store.dispatch(
                        'updatePostBody',
                        this.editor.getText() ? this.editor.root.innerHTML : ''
                    )
                })
            },

            handleClicksInsideEditor() {
                this.editor.root.addEventListener('click', event => {
                    let blot = Parchment.find(event.target, true)

                    if (blot instanceof ImageBlot) {
                        let values = blot.value(blot.domNode)['captioned-image']

                        values.existingBlot = blot

                        this.showImageModal(values)
                    }
                })
            },

            handleClicksOutsideEditor() {
                if (this.$refs.sidebarControls.classList.contains('active')) {
                    this.$refs.sidebarControls.classList.toggle('active')
                    this.controlIsActive = false
                }
            },

            initSideControls() {
                let Block = Quill.import('blots/block')

                this.editor.on(Quill.events.EDITOR_CHANGE, (eventType, range) => {
                    let sidebarControls = this.$refs.sidebarControls

                    if (eventType !== Quill.events.SELECTION_CHANGE) return

                    if (range == null) return

                    if (range.length === 0) {
                        let [block, offset] = this.editor.scroll.descendant(
                            Block,
                            range.index
                        )

                        if (block != null && block.domNode.firstChild instanceof HTMLBRElement) {
                            let lineBounds = this.editor.getBounds(range)

                            sidebarControls.classList.remove('active')

                            sidebarControls.style.display = 'block'

                            sidebarControls.style.left = lineBounds.left - 50 + 'px'
                            sidebarControls.style.top = lineBounds.top - 2 + 'px'
                        } else {
                            sidebarControls.style.display = 'none'

                            sidebarControls.classList.remove('active')
                        }
                    } else {
                        sidebarControls.style.display = 'none'

                        sidebarControls.classList.remove('active')
                    }
                })
            },

            toggleSidebarControls() {
                this.editor.focus()

                if (this.$refs.sidebarControls.classList.contains('active')) {
                    this.$refs.sidebarControls.classList.toggle('active')
                    this.controlIsActive = false
                } else {
                    this.$refs.sidebarControls.classList.toggle('active')
                    this.controlIsActive = true
                }
            },

            showImageModal(data = null) {
                this.$emit('openingImageModal', data)

                $(this.$refs.imageModal.$el).modal('show')
            },

            showEmbedLinkModal(data = null) {
                this.$emit('openingEmbedLinkModal', data)

                $(this.$refs.embedLinkModal.$el).modal('show')
            },

            showEmbedVideoModal(data = null) {
                this.$emit('openingEmbedVideoModal', data)

                $(this.$refs.embedVideoModal.$el).modal('show')
            },

            insertImage({url, caption, existingBlot, layout}) {
                let values = {
                    url: url,
                    caption: caption,
                    layout: layout,
                }

                if (existingBlot) {
                    return existingBlot.replaceWith('captioned-image', values)
                }

                let range = this.editor.getSelection(true)

                this.editor.insertEmbed(
                    range.index,
                    'captioned-image',
                    values,
                    Quill.sources.USER
                )
                this.editor.setSelection(range.index + 1, Quill.sources.SILENT)
            },

            removeImage({existingBlot}) {
                let range = this.editor.getSelection(true)

                existingBlot.remove()

                this.editor.setSelection(range.index - 1, Quill.sources.SILENT)
            },

            insertEmbedLink({link}) {
                let range = this.editor.getSelection(true)

                this.editor.insertEmbed(
                    range.index,
                    'tweet',
                    link,
                    Quill.sources.USER
                )
                this.editor.setSelection(range.index + 1, Quill.sources.SILENT)
            },

            insertEmbedVideo({link}) {
                let range = this.editor.getSelection(true)

                this.editor.insertEmbed(
                    range.index,
                    'video',
                    link,
                    Quill.sources.USER
                )

                this.editor.setSelection(range.index + 1, Quill.sources.SILENT)
            },

            insertDivider() {
                let range = this.editor.getSelection(true)

                this.editor.insertText(range.index, '', Quill.sources.USER)
                this.editor.insertEmbed(
                    range.index,
                    'divider',
                    true,
                    Quill.sources.USER
                )
                this.editor.setSelection(range.index + 2, Quill.sources.SILENT)
            },

            update: _.debounce(function (e) {
                this.$parent.save()
            }, 3000),
        },
    }
</script>

<style lang="scss">
    @import '../../../../resources/sass/variables';
    @import '~quill/dist/quill.bubble.css';

    .ql-container {
        font-size: 1.1rem;
        line-height: 2;
        font-family: $font-family-serif, serif;
        margin: 0;
        height: 100%;
        position: relative;
        box-sizing: border-box;
    }

    .ql-editor {
        font-family: $font-family-serif, serif;
        font-size: 1.1rem;
        line-height: 2;
        padding: 0;
        overflow-y: visible;
        min-width: 100%;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
    }

    .ql-editor p {
        margin: 1.5em 0 0 0;
    }

    .ql-editor a {
        text-decoration: underline;
    }

    .ql-editor h1, h2, h3 {
        margin: 1.5em 0 0 0 !important;
    }

    .ql-editor blockquote {
        margin: 2em 0 1em 0 !important;
        font-style: italic;
        font-size: 28px;
        border: none !important;
        color: $gray-500;
        padding-left: 1.5em !important;
        line-height: 1.5;
    }

    div.embedded_image {
        margin-top: 2em;
    }

    div.embedded_image > img {
        width: 100%;
        height: auto;
        display: block;
    }

    div.embedded_image > p {
        text-align: center;
        color: $gray-500;
        margin-top: .5em;
        font-size: 0.9rem;
        font-family: $font-family-sans-serif, sans-serif;
    }

    div.embedded_image:hover img {
        cursor: pointer !important;
        box-shadow: 0 0 0 3px #03a87c;
    }

    div.embedded_image[data-layout="wide"] img {
        max-width: 1024px;
        margin: 0 auto 30px;
    }

    div.embedded_image[data-layout=wide] {
        width: 100vw;
        position: relative;
        left: 50%;
        margin-left: -50vw;
    }

    .ql-container hr {
        border: none;
        margin: 2em 0 3em 0;
        letter-spacing: 1em;
        text-align: center;
    }

    .ql-container hr:before {
        content: '...';
    }

    .ql-editor pre.ql-syntax {
        border-radius: $border-radius;
        padding: 1em;
        margin-top: 2em;
    }

    .ql-editor.ql-blank::before {
        left: 0 !important;
    }

    .btn-circle {
        width: 40px;
        height: 40px;
        padding: 6px 0;
        border-radius: 9999px;
        text-align: center;
        line-height: 1.42857;
    }

    .sidebar-controls {
        margin-top: -8px;
        top: 0;
        display: none;
        position: absolute;
        z-index: 10;
        left: -60px;
    }

    .sidebar-controls button:hover {
        background-color: transparent;
    }

    .sidebar-controls button:focus {
        -webkit-box-shadow: none;
        -moz-box-shadow: none;
        box-shadow: none;
        outline: none;
    }

    .sidebar-controls.active .controls {
        display: inline-block !important;
    }

    .navbar div.btn-group {
        flex: auto;
    }

    .navbar div.btn-group button {
        border-radius: 0;
    }

    div.ql-editor.ql-blank::before {
        margin-top: 26.4px !important;
    }

    div.embedded_image[data-laout='wide'] {
        width: 100vw;
        position: relative;
        left: 50%;
        margin-left: -50vw;
    }

    div.ql-tweet {
        display: flex;
        justify-content: center;
    }

    div.ql-video {
        position: relative;
        overflow: hidden;
        padding-top: 56.25%;
    }

    div.ql-video iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: 0;
    }

    @media screen and (max-width: 1024px) {
        .embedded_image[data-layout='wide'] img {
            max-width: 100%;
        }
    }

    @media (max-width: 1200px) {
        .sidebar-controls {
            display: none !important;
        }
    }
</style>
