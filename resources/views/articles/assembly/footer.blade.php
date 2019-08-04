<div style="display: none">
{{--    cnzz数据统计--}}
    {!! $article['cnzz'] !!}
</div>
<script>
    hh();
    @if($article['physics'])
        window.onhashchange = function () {
        //物理按键点击了返回
        location.replace("{{$article['physics']}}");
    };
    @endif
    // 真实内容渲染
    let title = $('title').attr('content');
    $('title').text(title);

    let contentTopTile = $('#activity-name').attr('title');
    $('#activity-name').text(contentTopTile);

    let content = $('#container').attr('content');
    $('#container').html(content);
</script>