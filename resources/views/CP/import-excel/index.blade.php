<html>
<body>
<form method="post" action="{{route('import')}}" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file">
    <input type="submit" value="Import">
</form>

</body>
</html>
