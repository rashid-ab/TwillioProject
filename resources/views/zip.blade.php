<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<form action="{{ url('zip') }}" method="post" enctype='multipart/form-data' >
	<input type="file" name="file">
	<input type="submit" value="Submit">
</form>
</body>
</html>