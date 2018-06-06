<script type="text/javascript">
@if (!isset($call))
    $('.ibox').children('.ibox-content').toggleClass('sk-loading');
@else
    $(function () {
        if ($('.ibox-content').hasClass('sk-loading')) {
            window.setTimeout(function () {
                $('.ibox').children('.ibox-content').toggleClass('sk-loading');
            }, 2000);
        }
    });
@endif
</script>