<form role="form" id="form-edit" method="POST" action="{{ route('canvas.post.update', $data['post']->id) }}"
      enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="form-group row my-3">
        <div class="col-lg-12">
            <input type="text" class="form-control-lg form-control border-0 pl-0 serif py-5" style="font-size: 42px;"
                   name="title" title="Title" value="{{ $data['post']->title }}" placeholder="Post Title">
        </div>
    </div>

    {{-- todo: reason for double quotes here? --}}
    <editor value="{{ $data['post']->body }}"></editor>

    @include('canvas::canvas.components.modals.post.edit.share')
    @include('canvas::canvas.components.modals.post.edit.settings')
    @include('canvas::canvas.components.modals.post.edit.publish')
    @include('canvas::canvas.components.modals.post.edit.image')
    @include('canvas::canvas.components.modals.post.edit.seo')
</form>