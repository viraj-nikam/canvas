<form role="form" id="form-create" method="POST" action="{{ route('canvas.tag.store') }}">
    <div class="card border-0">
        <div class="card-body">
            @csrf
            <input type="hidden" name="id" hidden value="{{ $data['id'] }}">

            <div class="form-group row mb-5">
                <div class="col-lg-12">
                    <input type="text" class="form-control-lg form-control{{ $errors->has('name') ? ' is-invalid' : '' }} border-0" name="name"
                           title="Name" value="{{ old('name') }}" required placeholder="Give your tag a name">
                    @if ($errors->has('name'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('name') }}</strong>
                        </div>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-12">
                    <input type="text" class="form-control-lg form-control{{ $errors->has('slug') ? ' is-invalid' : '' }} border-0" name="slug"
                           title="Slug" value="{{ old('slug') }}" required placeholder="now-add-a-slug">
                    @if ($errors->has('slug'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('slug') }}</strong>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</form>