<script src="/vendors/bower_components/jquery/dist/jquery.min.js"></script>
<script src="/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="/vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="/vendors/bower_components/Waves/dist/waves.min.js"></script>
<script src="/vendors/bootstrap-growl/bootstrap-growl.min.js"></script>
<script src="/vendors/bower_components/bootstrap-sweetalert/lib/sweet-alert.min.js"></script>
<script src="/vendors/bower_components/lightgallery/light-gallery/js/lightGallery.min.js"></script>
<script src="/vendors/bower_components/autosize/dist/autosize.min.js"></script>
<script src="/vendors/bootgrid/jquery.bootgrid.updated.min.js"></script>
<script src="/js/functions.js"></script>

<!-- Data Table -->
<script type="text/javascript">
    $(document).ready(function(){
        //Basic Example
        $("#data-table-basic").bootgrid({
            css: {
                icon: 'zmdi icon',
                iconColumns: 'zmdi-view-module',
                iconDown: 'zmdi-sort-amount-desc',
                iconRefresh: 'zmdi-refresh',
                iconUp: 'zmdi-sort-amount-asc'
            },
        });

        //Selection
        $("#data-table-selection").bootgrid({
            css: {
                icon: 'zmdi icon',
                iconColumns: 'zmdi-view-module',
                iconDown: 'zmdi-sort-amount-desc',
                iconRefresh: 'zmdi-refresh',
                iconUp: 'zmdi-sort-amount-asc'
            },
            selection: true,
            multiSelect: true,
            rowSelect: true,
            keepSelection: true
        });

        //Command Buttons
        $("#data-table-command").bootgrid({
            css: {
                icon: 'zmdi icon',
                iconColumns: 'zmdi-view-module',
                iconDown: 'zmdi-sort-amount-desc',
                iconRefresh: 'zmdi-refresh',
                iconUp: 'zmdi-sort-amount-asc'
            },
            formatters: {
                "commands": function(column, row) {
                    return "<button type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-edit\"></span></button> " +
                            "<button type=\"button\" class=\"btn btn-icon command-delete waves-effect waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-delete\"></span></button>";
                }
            }
        });
    });
</script>