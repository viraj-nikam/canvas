@extends('admin')

@section('title')
    <title>{{ config('blog.title') }} | Uploads</title>
@stop

@section('content')
    <div class="container">
        <div class="row page-title-row">
            <div class="col-md-12">
                <h1 class="page-header">Uploads
                    <button type="button" class="btn btn-sm btn-success btn-outline" data-toggle="modal" data-target="#modal-folder-create">
                        <i class="fa fa-fw fa-plus"></i> New Folder
                    </button>
                    <button type="button" class="btn btn-sm btn-primary btn-outline" data-toggle="modal" data-target="#modal-file-upload">
                        <i class="fa fa-fw fa-upload"></i> Upload
                    </button>
                </h1>
                <div class="pull-left">
                    <ul class="breadcrumb">
                        @foreach ($breadcrumbs as $path => $disp)
                            <li><a href="/admin/upload?folder={{ $path }}">{{ $disp }}</a></li>
                        @endforeach
                        <li class="active">{{ $folderName }}</li>
                    </ul>
                </div>
            </div>
        </div>
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
                        {{-- The Subfolders --}}
                        @foreach ($subfolders as $path => $name)
                            <tr>
                                <td>
                                    <a href="/admin/upload?folder={{ $path }}"><i class="fa fa-folder-o fa-fw"></i> {{ $name }}
                                    </a></td>
                                <td>Folder</td>
                                <td>-</td>
                                <td>-</td>
                                <td>
                                    <button type="button" class="btn btn-xs btn-danger btn-outline" onclick="delete_folder('{{ $name }}')">
                                        <i class="fa fa-times-circle fa-fw"></i>Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach

                        {{-- The Files --}}
                        @foreach ($files as $file)
                            <tr>
                                <td>
                                    <a href="{{ $file['webPath'] }}" target="_blank">
                                        @if (is_image($file['mimeType']))
                                            <i class="fa fa-fw fa-file-image-o"></i>
                                        @else
                                            <i class="fa fa-fw fa-file-o"></i>
                                        @endif
                                        {{ $file['name'] }}
                                    </a>
                                </td>
                                <td>{{ $file['mimeType'] or 'Unknown' }}</td>
                                <td>{{ $file['modified']->format('j-M-y g:ia') }}</td>
                                <td>{{ human_filesize($file['size']) }}</td>
                                <td>
                                    <button type="button" class="btn btn-xs btn-danger btn-outline" onclick="delete_file('{{ $file['name'] }}')">
                                        <i class="fa fa-fw fa-times-circle"></i> Delete
                                    </button>
                                    @if (is_image($file['mimeType']))
                                        <button type="button" class="btn btn-xs btn-success btn-outline" onclick="preview_image('{{ $file['webPath'] }}')">
                                            <i class="fa fa-eye fa-fw"></i> Preview
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