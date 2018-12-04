<form role="form" id="form-edit" method="POST" action="{{ route('canvas.tag.update', $data['tag']->id) }}">
    @method('PUT')
    @csrf

    <tag-inputs :tag="{{ $data['tag'] }}" inline-template>
        <div>
            <div class="form-group row my-5">
                <div class="col-lg-12">
                    <input type="text" name="name" v-model="name"
                           class="form-control-lg form-control border-0 px-0"
                           title="Name" value="{{ $data['tag']->name }}" required placeholder="Give your tag a name">
                    @if ($errors->has('name'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('name') }}</strong>
                        </div>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-12">
                    <input type="text" name="slug" v-model="slug"
                           class="form-control-lg form-control border-0 px-0"
                           title="Slug" value="{{ $data['tag']->slug }}" required placeholder="now-add-a-slug">
                    @if ($errors->has('slug'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('slug') }}</strong>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </tag-inputs>
</form>