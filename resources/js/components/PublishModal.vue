<template>
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-12">
                            <label class="font-weight-bold">{{ __('canvas::posts.forms.publish.header') }}</label>
                            <p class="text-muted">{{ __('canvas::posts.forms.publish.subtext.details') }} <span class="font-weight-bold">{{ now()->timezoneName }}</span> {{ __('canvas::posts.forms.publish.subtext.timezone') }}.</p>

                            <date-time-picker :value="{{ $data['post']->published_at->format('Y-m-d\TH:i') }}">
                            </date-time-picker>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-primary"
                       onclick="event.preventDefault();document.getElementById('form-edit').submit();"
                       aria-label="Update post">{{ trans.buttons.posts.schedule }}</a>
                    <button type="button"
                            class="btn btn-link text-muted"
                            data-dismiss="modal">
                        {{ trans.buttons.general.cancel }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import DateTimePicker from './DateTimePicker';

    export default {
        name: 'publish-modal',

        components: {
            DateTimePicker
        },

        data() {
            return {
                trans: JSON.parse(Canvas.lang),
            }
        },
    }
</script>
