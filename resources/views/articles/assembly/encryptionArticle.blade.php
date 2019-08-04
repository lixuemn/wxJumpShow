<div id="encryp">
    {!! $content!!}
</div>

<script>
        let html = document.getElementById('encryp').innerHTML;
        html = utf8to16(atob(html));
        $('#encryp').html(html)
</script>