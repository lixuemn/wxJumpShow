<script>
    var ajax = new XMLHttpRequest();
    ajax.open('post', '/ajax/{{$id}}');
    ajax.send();
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4 && ajax.status == 200) {
            let obj = JSON.parse(ajax.responseText);
            document.getElementById('container').innerHTML = obj.content
        }
    }
</script>
<div id="ajax">

</div>