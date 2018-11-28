<div class="modal fade" id="modal-seo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-lg-4 col-form-label text-lg-left">Meta Description</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control{{ $errors->has('meta_description') ? ' is-invalid' : '' }}"
                               name="meta_description" title="Meta Description" value="{{ old('meta_description') }}"
                               placeholder="Meta Description">
                        @if ($errors->has('meta_description'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('meta_description') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-4 col-form-label text-lg-left">Facebook Card Title</label>
                    <div class="col-lg-8">
                        <input type="text"
                               class="form-control{{ $errors->has('og_title') ? ' is-invalid' : '' }}"
                               name="og_title" title="Facebook Card Title" value="{{ old('og_title') }}"
                               placeholder="Facebook Card Title">
                        @if ($errors->has('og_title'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('og_title') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-4 col-form-label text-lg-left">Facebook Card Description</label>
                    <div class="col-lg-8">
                        <input type="text"
                               class="form-control{{ $errors->has('og_description') ? ' is-invalid' : '' }}"
                               name="og_description" title="Facebook Card Description"
                               value="{{ old('og_description') }}"
                               placeholder="Facebook Card Description">
                        @if ($errors->has('og_description'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('og_description') }}</strong>
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
                        <input type="text" class="form-control{{ $errors->has('twitter_title') ? ' is-invalid' : '' }}"
                               name="twitter_title" title="Twitter Card Title" value="{{ old('twitter_title') }}"
                               placeholder="Twitter Card Title">
                        @if ($errors->has('twitter_title'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('twitter_title') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-4 col-form-label text-lg-left">Twitter Card Description</label>
                    <div class="col-lg-8">
                        <input type="text"
                               class="form-control{{ $errors->has('twitter_description') ? ' is-invalid' : '' }}"
                               name="twitter_description" title="Twitter Card Description"
                               value="{{ old('twitter_description') }}"
                               placeholder="Twitter Card Description">
                        @if ($errors->has('twitter_description'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('twitter_description') }}</strong>
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