<div class="clearfix modal-preview-demo">
    <div class="modal fade" id="modal-file-upload">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Upload a File</h4>
                </div>
                <form method="POST" action="/admin/upload/file" class="form-horizontal" enctype="multipart/form-data" id="fileCreate">
                    <div class="modal-body">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="folder" value="{{ $folder }}">
                        <input type="file" id="name" name="file">
                        <div class="clearfix"><br></div>
                        <div class="fg-line">
                            <input type="text" id="file_name" name="file_name" class="form-control" placeholder="Filename (Optional)">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-link btn-icon-text"><i class="zmdi zmdi-floppy"></i> Save</button>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>