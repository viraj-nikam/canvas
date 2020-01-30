<template>
    <div class="modal fade" tabindex="-1" role="dialog" data-backdrop="static">
        <div class="modal-dialog" id="htmlModal" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center justify-content-between border-0">
                    <h4 class="modal-title">{{ trans.posts.forms.editor.html.label }}</h4>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" class="icon-close-circle">
                            <circle cx="12" cy="12" r="10" class="primary"/>
                            <path class="fill-bg" d="M13.41 12l2.83 2.83a1 1 0 0 1-1.41 1.41L12 13.41l-2.83 2.83a1 1 0 1 1-1.41-1.41L10.59 12 7.76 9.17a1 1 0 0 1 1.41-1.41L12 10.59l2.83-2.83a1 1 0 0 1 1.41 1.41L13.41 12z"/>
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    <textarea
                        ref="content"
                        cols="30"
                        rows="10"
                        style="resize: none"
                        :class="!Canvas.darkMode ? 'bg-light': 'bg-darker'"
                        class="form-control border-0"
                        :placeholder="trans.posts.forms.editor.html.placeholder"
                        v-model="content">
                    </textarea>
                </div>
                <div class="modal-footer">
                    <button
                        class="btn btn-link btn-block text-muted font-weight-bold text-decoration-none"
                        @click="addHTML"
                        data-dismiss="modal">
                        {{ trans.buttons.general.done }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'html-modal',

        data() {
            // TODO: Add a resetComponent() method

            return {
                content: '',
                trans: JSON.parse(Canvas.lang),
            }
        },

        mounted() {
            this.$nextTick(() => this.$refs.content.focus())
        },

        methods: {
            addHTML() {
                this.$emit('addingHTML', {
                    content: this.content,
                })

                this.content = ''
            },
        },
    }
</script>
