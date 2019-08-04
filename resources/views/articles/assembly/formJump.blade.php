<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 3.2 Final//EN'>
<html>
<body>
<form name='ClientPage' method='post' action='http://{{$url}}/show/{{$articleId}}' >
    {{ csrf_field() }}
</form>
<script language='javascript'  type='text/javascript'>
    document.forms['ClientPage'].submit();
</script>
</body>
</html>
