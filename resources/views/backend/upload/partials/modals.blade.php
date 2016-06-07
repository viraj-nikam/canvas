<!-- Create Folder Modal -->
<div class="modal fade" id="modal-folder-create">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="/admin/upload/folder" class="form-horizontal">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="folder" value="{{ $folder }}">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title">New folder</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="col-sm-8">
                            <input type="text" id="new_folder_name" name="new_folder" class="form-control simplebox" placeholder="Folder Name">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-outline" data-dismiss="modal">Cancel</button>
                    &nbsp;
                    <button type="submit" class="btn btn-primary btn-outline">
                        <i class="material-icons">save</i>&nbsp;&nbsp;Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Delete File Modal -->
<div class="modal fade" id="modal-file-delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Delete this file?</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the file <b><span id="delete-file-name1"></span></b>?</p>
            </div>
            <div class="modal-footer">
                <form method="POST" action="/admin/upload/file">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="folder" value="{{ $folder }}">
                    <input type="hidden" name="del_file" id="delete-file-name2">
                    <button type="button" class="btn btn-default btn-default" data-dismiss="modal">Cancel</button>
                    &nbsp;
                    <button type="submit" class="btn btn-danger btn-outline">
                        <i class="material-icons">delete_forever</i>&nbsp;&nbsp;Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Delete Folder Modal -->
<div class="modal fade" id="modal-folder-delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Delete this folder?</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the folder <b><span id="delete-folder-name1"></span></b>?</p>
            </div>
            <div class="modal-footer">
                <form method="POST" action="/admin/upload/folder">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="folder" value="{{ $folder }}">
                    <input type="hidden" name="del_folder" id="delete-folder-name2">
                    <button type="button" class="btn btn-default btn-outline" data-dismiss="modal">Cancel</button>
                    &nbsp;
                    <button type="submit" class="btn btn-danger btn-outline">
                        <i class="material-icons">delete_forever</i>&nbsp;&nbsp;Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Upload File Modal -->
<div class="modal fade" id="modal-file-upload">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="/admin/upload/file" class="form-horizontal" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="folder" value="{{ $folder }}">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Upload file</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="file" class="col-sm-3 control-label">File</label>
                        <div class="col-sm-8">
                            <input type="file" id="file" name="file">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4">
                            <input type="text" id="file_name" name="file_name" class="form-control simplebox" placeholder="Optional filename">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-outline" data-dismiss="modal">Cancel</button>
                    &nbsp;
                    <button type="submit" class="btn btn-primary btn-primary btn-outline">
                        <i class="material-icons">save</i>&nbsp;&nbsp;Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- View Image Modal -->
<div class="modal fade" id="modal-image-view">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Image preview</h4>
            </div>
            <div class="modal-body">
                <img id="preview-image" src="x" class="img-responsive">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-outline" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>