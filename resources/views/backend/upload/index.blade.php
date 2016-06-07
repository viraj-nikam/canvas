@extends('layouts.admin')

@section('title')
    <title>{{ config('blog.title') }} | Uploads</title>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="page-header">
                <ul class="breadcrumb">
                    <li><a href="/admin">Home</a></li>
                    <li class="active">Uploads</li>
                </ul>
                <button type="button" class="btn btn-sm btn-success btn-outline" data-toggle="modal" data-target="#modal-folder-create">
                    <i class="material-icons">create_new_folder</i>&nbsp;&nbsp;New folder
                </button>
                &nbsp;
                <button type="button" class="btn btn-sm btn-primary btn-outline" data-toggle="modal" data-target="#modal-file-upload">
                    <i class="material-icons">cloud_upload</i>&nbsp;&nbsp;Upload
                </button>
            </div>
        </div>
    </div>

    <ul class="breadcrumb">
        @foreach ($breadcrumbs as $path => $disp)
            <li><a href="/admin/upload?folder={{ $path }}">{{ $disp }}</a></li>
        @endforeach
        <li class="active">{{ $folderName }}</li>
    </ul>

    <div class="row">
        <div class="col-sm-12">
            @include('shared.errors')
            @include('shared.success')
            <div class="table-responsive">
                <table id="uploads-table" class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Size</th>
                        <th data-sortable="false">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- The Subfolders -->
                    @foreach ($subfolders as $path => $name)
                        <tr>
                            <td>
                                <a href="/admin/upload?folder={{ $path }}"><i class="material-icons">folder_open</i>&nbsp;&nbsp;{{ $name }}
                                </a></td>
                            <td>Folder</td>
                            <td>-</td>
                            <td>-</td>
                            <td>
                                <button type="button" class="btn btn-xs btn-danger btn-outline" onclick="delete_folder('{{ $name }}')">
                                    <i class="material-icons">delete_forever</i>&nbsp;&nbsp;Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach

                    <!-- The Files -->
                    @foreach ($files as $file)
                        <tr>
                            <td>
                                <a href="{{ $file['webPath'] }}" target="_blank">
                                    @if (is_image($file['mimeType']))
                                        <i class="material-icons">photo</i>&nbsp;&nbsp;
                                    @else
                                        <i class="material-icons">insert_drive_file</i>&nbsp;&nbsp;
                                    @endif
                                    {{ $file['name'] }}
                                </a>
                            </td>
                            <td>{{ $file['mimeType'] or 'Unknown' }}</td>
                            <td>{{ $file['modified']->format('j-M-y g:ia') }}</td>
                            <td>{{ human_filesize($file['size']) }}</td>
                            <td>
                                <button type="button" class="btn btn-xs btn-danger btn-outline" onclick="delete_file('{{ $file['name'] }}')">
                                    <i class="material-icons">delete_forever</i>&nbsp;&nbsp;Delete
                                </button>
                                @if (is_image($file['mimeType']))
                                    &nbsp;
                                    <button type="button" class="btn btn-xs btn-success btn-outline" onclick="preview_image('{{ $file['webPath'] }}')">
                                        <i class="material-icons">visibility</i>&nbsp;&nbsp;Preview
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('site.admin.upload.partials.modals')
@stop

@section('scripts')
    <script>
        // Confirm file delete
        function delete_file(name) {
            $("#delete-file-name1").html(name);
            $("#delete-file-name2").val(name);
            $("#modal-file-delete").modal("show");
        }
        // Confirm folder delete
        function delete_folder(name) {
            $("#delete-folder-name1").html(name);
            $("#delete-folder-name2").val(name);
            $("#modal-folder-delete").modal("show");
        }
        // Preview image
        function preview_image(path) {
            $("#preview-image").attr("src", path);
            $("#modal-image-view").modal("show");
        }
        // Startup code
        $(function () {
            $("#uploads-table").DataTable({
                "order": [[0, "desc"]]
            });
        });
    </script>
@stop