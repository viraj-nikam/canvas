<div class="modal fade" id="modal-settings" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-lg-4 col-form-label text-lg-left">Slug</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control"
                               name="slug" title="Slug" value="{{ old('slug', 'post-'.$data['id']) }}" required
                               placeholder="a-unique-slug">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-4 col-form-label text-lg-left">Summary</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control"
                               name="summary" title="Summary" value="{{ old('summary') }}"
                               placeholder="A descriptive summary..">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-4 col-form-label text-lg-left">Tags</label>
                    <div class="col-lg-8">
                        <select class="form-control" name="tags" id="tags">
                            <option disabled selected>Select some tags..</option>
                            @foreach($data['tags'] as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-link text-muted" data-dismiss="modal">Done</button>
            </div>
        </div>
    </div>
</div>