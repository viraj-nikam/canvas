<template>
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-12">
                            <label class="font-weight-bold">{{ trans.posts.forms.publish.header }}</label>
                            <p class="text-muted">{{ trans.posts.forms.publish.subtext.details }} <span class="font-weight-bold">{{ moment.tz.guess() }}</span> {{ trans.posts.forms.publish.subtext.timezone }}.</p>

                            <date-time-picker
                                :value="formattedDate">
                            </date-time-picker>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-primary" onclick="event.preventDefault();document.getElementById('form-edit').submit();">
                        {{ trans.buttons.posts.schedule }}
                    </a>
                    <button type="button" class="btn btn-link text-muted" data-dismiss="modal">
                        {{ trans.buttons.general.cancel }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from 'moment-timezone';
    import DateTimePicker from './DateTimePicker';

    export default {
        name: 'publish-modal',

        components: {
            DateTimePicker
        },

        props: {
            input: {
                type: Object,
                required: true
            }
        },

        mounted() {
            this.form.published_at = this.input.published_at;
        },

        data() {
            return {
                form: {
                    published_at: ''
                },
                trans: JSON.parse(Canvas.lang),
            }
        },

        computed: {
            formattedDate() {
                return moment(this.form.published_at, 'Y-m-d\TH:i');
            }
        }
    }
</script>
