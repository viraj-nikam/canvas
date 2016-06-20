@extends('backend.layout')

@section('title')
    <title>{{ config('blog.title') }} | Uploads</title>
@stop

@section('content')
    <section id="main">
        @include('backend.partials.sidebar-navigation')
        <section id="content">
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        <ol class="breadcrumb">
                            <li><a href="/admin">Home</a></li>
                            <li class="active">Uploads</li>
                        </ol>
                        <ul class="actions">
                            <li class="dropdown">
                                <a href="" data-toggle="dropdown">
                                    <i class="zmdi zmdi-more-vert"></i>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <a href="">Refresh Uploads</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>

                        @include('shared.errors')
                        @include('shared.success')

                        <h2>Manage Uploads&nbsp;
                            <a href="" data-toggle="modal" data-target="#modal-folder-create"><i class="zmdi zmdi-folder-outline" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="New folder"></i></a>
                            &nbsp;
                            <a href="" data-toggle="modal" data-target="#modal-file-upload"><i class="zmdi zmdi-file-plus" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Upload file"></i></a>
                            <small>This page provides a comprehensive overview of all media uploads. Click the preview icon next to an image to view it or click the delete icon to remove it from the library.</small>
                        </h2>

                        <br>

                        <ul class="breadcrumb folder-paths">
                            @foreach ($breadcrumbs as $path => $disp)
                                <li><a href="/admin/upload?folder={{ $path }}">{{ $disp }}</a></li>
                            @endforeach
                            <li class="active">{{ $folderName }}</li>
                        </ul>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-condensed table-vmiddle">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Date</th>
                                    <th>Size</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(empty($files) && empty($subfolders))
                                    <tr><td>Folder <em>{{ $folderName }}</em> is empty.</td></tr>
                                @else
                                    @include('backend.upload.partials.folders-row')
                                    @include('backend.upload.partials.files-row')
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </section>
    @include('backend.upload.partials.view-image-modal')
    @include('backend.upload.partials.upload-file-modal')
    @include('backend.upload.partials.delete-file-modal')
    @include('backend.upload.partials.delete-folder-modal')
    @include('backend.upload.partials.create-folder-modal')
@stop

@section('unique-js')
    <script type="text/javascript">
        function delete_file(name) {
            $("#delete-file-name1").html(name);
            $("#delete-file-name2").val(name);
            $("#modal-file-delete").modal("show");
        }

        function delete_folder(name) {
            $("#delete-folder-name1").html(name);
            $("#delete-folder-name2").val(name);
            $("#modal-folder-delete").modal("show");
        }

        function preview_image(path) {
            $("#preview-image").attr("src", path);
            $("#modal-image-view").modal("show");
        }
    </script>
    {!! JsValidator::formRequest('App\Http\Requests\UploadNewFolderRequest', '#folderCreate'); !!}
    {!! JsValidator::formRequest('App\Http\Requests\UploadFileRequest', '#fileCreate'); !!}

    @if(Session::get('_new-folder'))
        @include('backend.upload.partials.new-folder-notification')
        {{ \Session::forget('_new-folder') }}
    @endif

    @if(Session::get('_delete-folder'))
        @include('backend.upload.partials.delete-folder-notification')
        {{ \Session::forget('_delete-folder') }}
    @endif

    @if(Session::get('_new-file'))
        @include('backend.upload.partials.new-file-notification')
        {{ \Session::forget('_new-file') }}
    @endif

    @if(Session::get('_delete-file'))
        @include('backend.upload.partials.delete-file-notification')
        {{ \Session::forget('_delete-file') }}
    @endif
@stop