<template>
    <div ref="modal" v-cloak class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <p>{{ trans.app.paste_a_link_to_embed_content }}</p>
                    <input
                        v-model="link"
                        ref="link"
                        type="text"
                        class="form-control border-0"
                        name="link"
                        placeholder="https://twitter.com/jack/status/20"
                        @keyup.enter="addLink"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import $ from 'jquery';

export default {
    name: 'embed-link-modal',

    data() {
        return {
            link: '',
            trans: JSON.parse(window.Canvas.locale.translations),
        };
    },

    methods: {
        addLink() {
            this.$emit('addingEmbedLink', {
                url: this.link,
            });

            $(this.$refs.modal).modal('hide');
            this.link = '';
        },
    },
};
</script>
