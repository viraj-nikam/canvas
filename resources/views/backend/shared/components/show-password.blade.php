<style type="text/css">
    button.show-password{
        background-color: #2196f3;
        border: 1px solid #2196f3;
        border-radius: 2px;
        color: #fff;
        font-size: 0.9em;
        opacity: .5;
        position: absolute;
        right: 0;
        top: 0;
    }
    button.show-password:hover{
        opacity: 1;
        transition: all .8s linear;
    }
</style>

<script>
        (function(){
            $('{!! $inputs !!}').parent().append('<button class="show-password">Show content</button>');

            $('.show-password').click(function (e) {
                var password_field = $(this).siblings('input');
                var new_type = (password_field.attr('type') === 'password') ? 'text' : 'password';
                var new_text = ($(this).html() === 'Show content') ? 'Hide' : 'Show';
                password_field.attr('type', new_type).focus();
                $(this).html(new_text + ' content');
            });
        })();
</script>
