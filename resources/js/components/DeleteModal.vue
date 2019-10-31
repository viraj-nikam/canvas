<template>
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <p class="font-weight-bold lead">
                        {{ header }}
                    </p>
                    <p>
                        {{ message }}
                    </p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-link btn-block font-weight-bold text-muted text-decoration-none" data-dismiss="modal">
                        {{ trans.buttons.general.cancel }}
                    </button>
                    <a href="#" class="btn btn-danger btn-block font-weight-bold mt-0" aria-label="Delete" @click.prevent="confirmProceed()">
                        {{ trans.buttons.general.delete }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "delete-modal",

        props: {
            header: {
                type: String,
                required: true
            },
            message: {
                type: String,
                required: true
            }
        },

        data() {
            return {
                trans: JSON.parse(Canvas.lang)
            };
        },

        methods: {
            confirmProceed() {
                this.$emit("delete");
            }
        }
    };
</script>
