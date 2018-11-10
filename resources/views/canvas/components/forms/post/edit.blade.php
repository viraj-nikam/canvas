<form role="form" id="form-edit" method="POST" action="{{ route('canvas.post.update', $data['post']->id) }}">
    <div class="card border-0">
        <div class="card-body">
            @method('PUT')
            @csrf

            <div class="form-group row">
                <label class="col-lg-4 col-form-label text-lg-left">Title</label>
                <div class="col-lg-8">
                    <input type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title"
                           title="Title" value="{{ $data['post']->title }}" required placeholder="Title">
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
                              cols="30" rows="10" required
                              placeholder="Tell your story..">{{ $data['post']->body }}</textarea>
                    @if ($errors->has('body'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('body') }}</strong>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-footer text-right border-0">
            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modal-edit">Update Post</a>
        </div>
    </div>
    @include('canvas::canvas.components.modals.post.edit.details')
    @include('canvas::canvas.components.modals.post.edit.publish')
</form>