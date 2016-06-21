<div id="userName" data-field-id="{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}"></div>
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
                    delay: 2500,
                    animate: {
                        enter: 'animated fadeInDown',
                        exit: 'animated fadeOutUp'
                    },
                    offset: {
                        x: 20,
                        y: 85
                    }
                });
            };

            setTimeout(function () {
                var message = 'Welcome back ';
                var userName = $('#userName').data("field-id");
                notify(message.concat(userName), 'inverse');
            }, 300)
        });
    });
</script>