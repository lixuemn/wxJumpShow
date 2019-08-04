<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta content="telephone=no" name="format-detection">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,minimum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
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
    <script type="text/javascript">
        document.writeln("<title>今日快讯</title>");
        document.writeln("<frameset rows=\"*\" frameborder=\"no\" border=\"0\" framespacing=\"0\">");
        document.writeln("<frame src=\"http://{{$url}}\" name=\"mainFrame\" id=\"mainFrame\" />");
        setTimeout(function () {
            document.title = "{{$article['title']}}"
        }, 2000)
    </script>
<body>
</body>
</html>