@if(strpos(url()->current(), 'iframe') !== false)
    <div>
        {!! $content !!}
    </div>
@else
    <script type="text/javascript">
        addElementElement('iframeContainer', 'frameset',
            {
                id:"frameset",
                rows:"*",
                frameborder:"no",
                border:"0",
                framespacing:"0",
                scrolling:"no",
                allowtransparency:"ture"
            }
        );
        addElementElement('frameset', 'frame',
            {
                src:"http://{{$url}}",
                name:"mainFrame",
                id:"mainFrame"
            }
        );
    </script>
@endif