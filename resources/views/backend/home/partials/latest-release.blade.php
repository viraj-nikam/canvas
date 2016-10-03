<script type="text/javascript">
    if (jQuery) {
        (function ($, undefined) {
            'use strict';
            $(function () {
                main();
            });
            function main() {
                $(document).ready(function () {
                    $.get('https://api.github.com/repos/austintoddj/canvas/releases/latest', function (res) {
                        $('#tag_name').html(res.tag_name);
                    });
                });
            }
        })(jQuery);
    }
</script>