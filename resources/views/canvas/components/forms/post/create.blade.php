<form role="form" method="POST" action="{{ route('canvas.posts.store') }}">
    <div class="card mt-3 shadow-sm">
        <div class="card-body">
            @csrf
            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

            <div class="form-group row">
                <label class="col-lg-4 col-form-label text-lg-left">Title</label>
                <div class="col-lg-8">
                    <input type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title"
                           title="Title" value="{{ old('title') }}" required placeholder="Title">
                    @if ($errors->has('title'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('title') }}</strong>
                        </div>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-4 col-form-label text-lg-left">Summary</label>
                <div class="col-lg-8">
                    <input type="text" class="form-control{{ $errors->has('summary') ? ' is-invalid' : '' }}"
                           name="summary" title="Summary" value="{{ old('summary') }}" required  placeholder="A descriptive summary..">
                    @if ($errors->has('summary'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('summary') }}</strong>
                        </div>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-4 col-form-label text-lg-left">Body</label>
                <div class="col-lg-8">
                    <textarea class="form-control{{ $errors->has('body') ? ' is-invalid' : '' }}" name="body" id="body" cols="30" rows="10" required placeholder="Tell your story..">{{ old('body') }}</textarea>
                    @if ($errors->has('body'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('body') }}</strong>
                        </div>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-4 col-form-label text-lg-left">Tags</label>
                <div class="col-lg-8">
                    <select name="tags" id="tags" class="form-control">
                        <option value="" disabled selected>Add a tag..</option>
                        @foreach($data['tags'] as $key => $tag)
                            <option value="{{ $key }}">{{ $tag }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="card-footer text-right border-0">
            <a href="{{ route('canvas.posts.index') }}" class="btn btn-link">Cancel</a>
            <button type="submit" class="btn btn-primary btn-spin">Save & Publish</button>
        </div>
    </div>
</form>