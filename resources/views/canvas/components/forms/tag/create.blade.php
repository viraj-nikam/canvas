<form role="form" id="form-create" method="POST" action="{{ route('canvas.tag.store') }}">
    @csrf
    <input type="hidden" name="id" hidden value="{{ $data['id'] }}">

    <tag-inputs inline-template>
        <div>
            <div class="form-group row my-5">
                <div class="col-lg-12">
                    <input type="text" name="name" v-model="name" title="Name"
                           class="form-control-lg form-control border-0 px-0"
                           value="{{ old('name') }}" required placeholder="Give your tag a name">
                    @if ($errors->has('name'))
                        <div class="invalid-feedback d-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </div>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-12">
                    <input type="text" name="slug" title="Slug" v-model="slug" required placeholder="now-add-a-slug"
                           class="form-control-lg form-control border-0 px-0">
                    @if ($errors->has('slug'))
                        <div class="invalid-feedback d-block">
                            <strong>{{ $errors->first('slug') }}</strong>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </tag-inputs>
</form>
