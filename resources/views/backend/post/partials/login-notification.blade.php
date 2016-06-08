<div id="userName" data-field-id="{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}"></div>
<script type="text/javascript">
    $(document).ready(function(){
        // Login Message
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
                        from: 'bottom',
                        align: 'left'
                    },
                    delay: 2500,
                    animate: {
                        enter: 'animated fadeInUp',
                        exit: 'animated fadeOutDown'
                    },
                    offset: {
                        x: 30,
                        y: 30
                    }
                });
            };

            setTimeout(function () {
                if (!$('.login-content')[0]) {
                    var message = 'Welcome back ';
                    var userName = $('#userName').data("field-id");
                    notify(message.concat(userName), 'inverse');
                }
            }, 1000)
        });
    });
</script>