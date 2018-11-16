<form role="form" id="form-create" method="POST" action="{{ route('canvas.post.store') }}">
    <div class="card border-0">
        <div class="card-body">
            @csrf
            <input type="hidden" name="id" hidden value="{{ $data['id'] }}">

            <div class="form-group row">
                <label class="col-lg-4 col-form-label text-lg-left">Title</label>
                <div class="col-lg-8">
                    <input type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title"
                           title="Title" value="{{ old('title') }}" required placeholder="Post Title">
                    @if ($errors->has('title'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('title') }}</strong>
                        </div>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-4 col-form-label text-lg-left">Body</label>
                <div class="col-lg-8">
                    <textarea class="form-control{{ $errors->has('body') ? ' is-invalid' : '' }}" name="body" id="body"
                              cols="30" rows="10" required placeholder="Tell your story..">{{ old('body') }}</textarea>
                @if ($errors->has('body'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('body') }}</strong>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-footer text-right border-0">
            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modal-create">Ready to publish?</a>
        </div>
    </div>
    @include('canvas::canvas.components.modals.post.create.details')
    @include('canvas::canvas.components.modals.post.create.publish')
</form>