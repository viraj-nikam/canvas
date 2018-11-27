<div class="modal fade" id="modal-seo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">SEO & Social</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-lg-4 col-form-label text-lg-left">Meta Description</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control{{ $errors->has('slug') ? ' is-invalid' : '' }}"
                               name="meta-description" title="Meta Description" value="{{ old('meta-description') }}"
                               placeholder="Meta Description">
                        @if ($errors->has('meta-description'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('meta-description') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-4 col-form-label text-lg-left">Facebook Card Title</label>
                    <div class="col-lg-8">
                        <input type="text"
                               class="form-control{{ $errors->has('opengraph-title') ? ' is-invalid' : '' }}"
                               name="opengraph-title" title="Facebook Card Title" value="{{ old('opengraph-title') }}"
                               placeholder="Facebook Card Title">
                        @if ($errors->has('opengraph-title'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('opengraph-title') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-4 col-form-label text-lg-left">Facebook Card Description</label>
                    <div class="col-lg-8">
                        <input type="text"
                               class="form-control{{ $errors->has('opengraph-description') ? ' is-invalid' : '' }}"
                               name="opengraph-description" title="Facebook Card Description"
                               value="{{ old('opengraph-description') }}"
                               placeholder="Facebook Card Description">
                        @if ($errors->has('opengraph-description'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('opengraph-description') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-4 col-form-label text-lg-left">Facebook Card Image</label>
                    <div class="col-lg-8">
                        Please <a href="#">upload</a> an image.
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-4 col-form-label text-lg-left">Twitter Card Title</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control{{ $errors->has('twitter-title') ? ' is-invalid' : '' }}"
                               name="twitter-title" title="Twitter Card Title" value="{{ old('twitter-title') }}"
                               placeholder="Twitter Card Title">
                        @if ($errors->has('twitter-title'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('twitter-title') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-4 col-form-label text-lg-left">Twitter Card Description</label>
                    <div class="col-lg-8">
                        <input type="text"
                               class="form-control{{ $errors->has('twitter-description') ? ' is-invalid' : '' }}"
                               name="twitter-description" title="Twitter Card Description"
                               value="{{ old('twitter-description') }}"
                               placeholder="Twitter Card Description">
                        @if ($errors->has('twitter-description'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('twitter-description') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-4 col-form-label text-lg-left">Twitter Card Image</label>
                    <div class="col-lg-8">
                        Please <a href="#">upload</a> an image.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-link text-muted" data-dismiss="modal">Done</button>
            </div>
        </div>
    </div>
</div>