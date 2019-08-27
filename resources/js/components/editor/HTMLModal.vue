<template>
    <div>
        <div class="modal fade" tabindex="-1" role="dialog" data-backdrop="static">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <p class="font-weight-bold lead">{{ trans.posts.forms.editor.html.label }}</p>
                        <div class="form-group row">
                            <div class="col-lg-12 mx-0 px-0">
                            <textarea ref="content"
                                      cols="30"
                                      rows="10"
                                      class="form-control border-0"
                                      :placeholder="trans.posts.forms.editor.html.placeholder"
                                      style="resize: none"
                                      :value="content">
                            </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            class="btn btn-link text-muted"
                            type="button"
                            data-dismiss="modal"
                            @click="addingHTML">
                            {{ trans.buttons.general.done }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'html-modal',

        data() {
            return {
                content: '',
                trans: JSON.parse(Canvas.lang),
            }
        },

        methods: {
            addingHTML() {
                this.$emit('addingHTML', {
                    content: this.content,
                });

                this.content = '';
            }
        }
    }
</script>
