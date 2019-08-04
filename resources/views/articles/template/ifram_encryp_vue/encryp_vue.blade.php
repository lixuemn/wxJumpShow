<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta id="_token" name="csrf-token" content="{{ csrf_token() }}" />
    <meta id="X_CSRF_TOKEN" name="X-CSRF-TOKEN" content="{{ csrf_token() }}" />
    <meta name="viewport" content="initial-scale=1, width=device-width, user-scalable=no"/>
    <script src="/js/article.js"></script>
    <link rel="stylesheet" type="text/css" href="/css/page.css">
    <link rel="stylesheet" type="text/css" href="/css/article.css">
    <link rel="stylesheet" type="text/css" href="/css/audio.css">
    <script src="/js/jquery-1.10.2.min.js"></script>
    
    <script type="text/javascript">
        window.addEventListener('load', function () {
            setTimeout(function () {
                var html = document.getElementById('encrypt_content').innerHTML;
                html = utf8to16(atob(html));
                var newDoc = document.open("text/html", "replace");
                newDoc.write(html);
            }, 100);
        });</script>
</head>
<body>
@include('articles.assembly.music')
@include('articles.assembly.backArrow')

<script type="text/template" id="encrypt_content">
        {!! $result !!}
</script>

@include('articles.assembly.footer')
</body>
</html>
