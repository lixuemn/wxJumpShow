@if($article['arrow'])
{{--    如果传递了返回箭头的地址才渲染这个元素--}}
<span id="backControl">
    <a class="on" href="{{$article['arrow']}}"></a>
</span>
@endif