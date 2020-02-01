<template>
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" ref="modal" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-group row mb-0">
                        <div class="col-12">
                            <p>Paste a YouTube, Vine, Vimeo, or other video link and press enter</p>
                            <input
                                type="text"
                                ref="link"
                                @keyup.enter="addLink"
                                v-model="link"
                                :class="!Canvas.darkMode ? 'bg-light': 'bg-darker'"
                                class="form-control border-0"
                                name="link"
                                placeholder="https://www.youtube.com/watch?v=jNQXAC9IVRw"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'embed-link-modal',

        data() {
            return {
                link: '',
                trans: JSON.parse(Canvas.lang),
            }
        },

        mounted() {
            this.$nextTick(() => this.$refs.link.focus())
        },

        methods: {
            addLink() {
                this.$emit('addingEmbeddedLink', {
                    link: this.link,
                })

                this.$refs.modal.hide
                this.content = ''
            },
        },
    }
</script>
