<!-- CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.3/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/node-waves/0.7.5/waves.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-growl/1.0.0/jquery.bootstrap-growl.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/0.4.5/sweet-alert.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.2.19/js/lightgallery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/autosize.js/3.0.15/autosize.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-bootgrid/1.3.1/jquery.bootgrid.min.js"></script>

<!-- Scripts -->
<script src="/js/functions.js"></script>

<!-- Data Table -->
<script type="text/javascript">
    $(document).ready(function(){
        // Posts Table
        $("#data-table-posts").bootgrid({
            css: {
                icon: 'zmdi icon',
                iconColumns: 'zmdi-view-module',
                iconDown: 'zmdi-sort-amount-desc',
                iconRefresh: 'zmdi-refresh',
                iconUp: 'zmdi-sort-amount-asc'
            },
            formatters: {
                "commands": function(column, row) {
                    return "<a href='/admin/post/{{ $post->id }}/edit'><button type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-edit\"></span></button></a> " +
                            " <a href='/blog/{{ $post->slug }}'><button type=\"button\" class=\"btn btn-icon command-delete waves-effect waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-search\"></span></button></a>";
                }
            }
        });
    });
</script>