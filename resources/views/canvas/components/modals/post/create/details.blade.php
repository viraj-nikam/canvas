<div class="modal fade" id="modal-details" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-lg-4 col-form-label text-lg-left">Slug</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control{{ $errors->has('slug') ? ' is-invalid' : '' }}"
                               name="slug" title="Slug" value="{{ old('slug', 'post-'.$data['id']) }}" required
                               placeholder="A unique slug..">
                        @if ($errors->has('summary'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('summary') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-4 col-form-label text-lg-left">Summary</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control{{ $errors->has('summary') ? ' is-invalid' : '' }}"
                               name="summary" title="Summary" value="{{ old('summary') }}" required
                               placeholder="A descriptive summary..">
                        @if ($errors->has('summary'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('summary') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-4 col-form-label text-lg-left">Tags</label>
                    <div class="col-lg-8">
                        <select name="tags" id="tags" class="form-control">
                            <option value="" disabled selected>Add some tags..</option>
                            @foreach($data['tags'] as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-link text-muted"data-dismiss="modal">Done</button>
            </div>
        </div>
    </div>
</div>