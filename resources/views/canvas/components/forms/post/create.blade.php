<form role="form" id="form-create" method="POST" action="{{ route('canvas.post.store') }}"
      enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" hidden value="{{ $data['id'] }}">

    <div class="form-group row my-3">
        <div class="col-lg-12">
            <input type="text" class="form-control-lg form-control border-0 pl-0 serif py-5" style="font-size: 42px;"
                   name="title" title="Title" value="{{ old('title') }}" placeholder="Post Title">
        </div>
    </div>

    <editor></editor>

    @include('canvas::canvas.components.modals.post.create.settings')
    @include('canvas::canvas.components.modals.post.create.publish')
    @include('canvas::canvas.components.modals.post.create.image')
    @include('canvas::canvas.components.modals.post.create.seo')
</form>