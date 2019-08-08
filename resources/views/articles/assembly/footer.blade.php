<div style="display: none">
{{--    cnzz数据统计--}}
    {!! $article['cnzz'] !!}
</div>
<input type="text" style="display: none" id="physics" value="{{$article['physics']}}">
<script>
    // 真实内容渲染
    let title = $('title').attr('content');
    $('title').text(title);

    let contentTopTile = $('#activity-name').attr('title');
    $('#activity-name').text(contentTopTile);

    let content = $('#container').attr('content');
    $('#container').html(content);
</script>