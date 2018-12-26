<div class="modal fade" id="modal-settings" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <p class="font-weight-bold lead">General settings</p>

                <div class="form-group row">
                    <div class="col-12">
                        <label for="published_at" class="font-weight-bold">Slug</label>
                        <input type="text" class="form-control border-0 px-0"
                               name="slug" title="Slug" value="{{ $data['post']->slug }}" required
                               placeholder="a-unique-slug">
                        @if ($errors->has('slug'))
                            <div class="invalid-feedback d-block">
                                <strong>{{ $errors->first('slug') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <label for="summary" class="font-weight-bold">Summary</label>
                        <input type="text" class="form-control border-0 px-0"
                               name="summary" title="Summary" value="{{ $data['post']->summary }}"
                               placeholder="A descriptive summary..">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <label for="published_at" class="font-weight-bold">Tags</label>

                        <multi-select :tags="{{ $data['tags'] }}" :selected="{{ $data['post']->tags }}"></multi-select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-link text-muted"data-dismiss="modal">Done</button>
            </div>
        </div>
    </div>
</div>
