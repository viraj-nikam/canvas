<script type="text/javascript">
    $(document).ready(function(){
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
                    return "<a href='/admin/post/{{ $post->id }}/edit'><button type='button' class='btn btn-icon command-edit waves-effect waves-circle' data-row-id='" + row.id + "'><span class='zmdi zmdi-edit'></span></button></a> " +
                            " <a href='/blog/{{ $post->slug }}' target='_blank'><button type='button' class='btn btn-icon command-delete waves-effect waves-circle' data-row-id='" + row.id + "'><span class='zmdi zmdi-search'></span></button></a>";
                }
            }
        });
    });
</script>