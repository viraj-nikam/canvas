<div class="modal fade" id="reset-index" tabIndex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Are you sure?</h4>
            </div>
            <div class="modal-body">
                <p>Depending on the number of blog posts and tags on the site, this could take a significant amount of time to run.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                <a href="{{ url('admin/tools/reset_index') }}">
                    <button class="btn btn-link btn-icon-text">
                        <i class="zmdi zmdi-refresh-alt"></i> Reset Index
                    </button>
                </a>
            </div>
        </div>
    </div>
</div>