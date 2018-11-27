<form role="form" id="form-create" method="POST" action="{{ route('canvas.post.store') }}">
    @csrf
    <input type="hidden" name="id" hidden value="{{ $data['id'] }}">

    <div class="form-group row my-5">
        <div class="col-lg-12">
            <input type="text" class="form-control-lg form-control{{ $errors->has('title') ? ' is-invalid' : '' }} border-0" name="title"
                   title="Title" value="{{ old('title') }}" placeholder="Post Title">
            @if ($errors->has('title'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('title') }}</strong>
                </div>
            @endif
        </div>
    </div>
    <div class="form-group row">
        <div class="col-lg-12">
                    <textarea class="form-control-lg form-control{{ $errors->has('body') ? ' is-invalid' : '' }} border-0" name="body" id="body"
                              cols="30" rows="10" placeholder="Tell your story..">{{ old('body') }}</textarea>
            @if ($errors->has('body'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('body') }}</strong>
                </div>
            @endif
        </div>
    </div>
    @include('canvas::canvas.components.modals.post.create.settings')
    @include('canvas::canvas.components.modals.post.create.publish')
    @include('canvas::canvas.components.modals.post.create.image')
    @include('canvas::canvas.components.modals.post.create.seo')
</form>