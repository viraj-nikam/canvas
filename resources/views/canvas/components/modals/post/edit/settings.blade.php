<div class="modal fade" id="modal-settings" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-12">
                        <label for="published_at" class="font-weight-bold">Slug</label>
                        <input type="text" class="form-control{{ $errors->has('slug') ? ' is-invalid' : '' }}"
                               name="slug" title="Slug" value="{{ $data['post']->slug }}" required
                               placeholder="a-unique-slug">
                        @if ($errors->has('slug'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('slug') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <label for="published_at" class="font-weight-bold">Tags</label>
                        <select class="custom-select" name="tags" id="tags">
                            <option disabled selected>Select some tags..</option>
                            @foreach($data['post']->tags as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <label for="published_at" class="font-weight-bold">Summary</label>
                        <input type="text" class="form-control"
                               name="summary" title="Summary" value="{{ $data['post']->summary }}"
                               placeholder="A descriptive summary..">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-link text-muted"data-dismiss="modal">Done</button>
            </div>
        </div>
    </div>
</div>
