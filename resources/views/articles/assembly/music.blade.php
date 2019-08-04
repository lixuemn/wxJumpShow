@if($article['music'])
{{--如果传递了音乐地址才渲染元素--}}
<audio id="audio" autoplay="autoplay" loop="true"
    src="{{$article['music']}}">
</audio>

<img id="status" onclick="controlMusic()" src="/img/audio.png" class="Rotation">
@endif

