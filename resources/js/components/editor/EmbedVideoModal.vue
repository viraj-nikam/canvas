<template>
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" ref="modal" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-group row mb-0">
                        <div class="col-12">
                            <p>Paste a link to embed content from another site (ie. Twitter) and press enter</p>
                            <input
                                type="text"
                                ref="link"
                                @keyup.enter="addLink"
                                v-model="link"
                                :class="!Canvas.darkMode ? 'bg-light': 'bg-darker'"
                                class="form-control border-0"
                                name="link"
                                placeholder="https://twitter.com/jack/status/20"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'embed-video-modal',

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
                this.$emit('addingEmbeddedVideo', {
                    link: this.link,
                })

                this.$refs.modal.hide
                this.content = ''
            },
        },
    }
</script>
