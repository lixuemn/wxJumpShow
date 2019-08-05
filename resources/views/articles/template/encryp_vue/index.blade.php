<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta id="_token" name="csrf-token" content="{{csrf_token()}}">
    <meta id="X_CSRF_TOKEN" name="X-CSRF-TOKEN" content="{{csrf_token()}}">
    <link rel="stylesheet" type="text/css" href="/css/page.css">
    <link rel="stylesheet" type="text/css" href="/css/article.css">
    <link rel="stylesheet" type="text/css" href="/css/audio.css">
    <script src="/js/jquery-1.10.2.min.js"></script>
    <script src="/js/article.js"></script>

    @if($article['check_cookie'] == \App\Models\LocalArticle::OPEN)
        <script src="/js/cookieCheck.js"></script>
    @endif

    <meta name="description" content="{{$article['description']}}">
    <title content="{{$article['title']}}"></title>
    <style>
        body {
            -webkit-touch-callout: none;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-box-align: stretch;
            position: relative;
        }
    </style>

    <script type="text/javascript">
        window.addEventListener('load', function () {
            setTimeout(function () {
                var html = document.getElementById('enContent').innerHTML;
                html = utf8to16(atob(html));
                $('#showContent').html(html);
                // 真实内容渲染
                let title = $('title').attr('content');
                $('title').text(title);

                let contentTopTile = $('#activity-name').attr('title');
                $('#activity-name').text(contentTopTile);

                let content = $('#container').attr('content');
                $('#container').html(content);
            }, 100);
        });</script>
</head>
<body>
<input style="display: none;"
       type="text"
       id="articleId"
       value="{{$article['id']}}"
>
@include('articles.assembly.music')
@include('articles.assembly.backArrow')
<div style="display: none" id="enContent">{!! $content !!}</div>
<div id="showContent"></div>
@include('articles.assembly.footer')
</body>
</html>