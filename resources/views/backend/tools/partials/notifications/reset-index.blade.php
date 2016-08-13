<div id="_reset-index" data-field-id="{{ Session::get('_reset-index') }}"></div>

<script type="text/javascript">
    $(document).ready(function(){
        $(window).load(function(){
            function notify(message, type){
                $.growl({
                    message: message
                },{
                    type: type,
                    allow_dismiss: false,
                    label: 'Cancel',
                    className: 'btn-xs btn-inverse',
                    placement: {
                        from: 'top',
                        align: 'right'
                    },
                    delay: 3200,
                    animate: {
                        enter: 'animated fadeInRight',
                        exit: 'animated fadeOutRight'
                    },
                    offset: {
                        x: 20,
                        y: 85
                    }
                });
            }

            setTimeout(function () {
                var message = $('#_reset-index').data("field-id");
                notify(message, 'inverse');
            }, 300)
        });
    });
</script>