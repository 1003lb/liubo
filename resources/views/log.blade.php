<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
<h1>登录</h1>
	<form action="{{url('/dologin')}}" method="post">
	@csrf
	用户名<input type="text" name="a_name"><br>
	密码<input type="password" name="pwd"><br>
	<input type="submit" value="登录">
	</form>
</body>
</html>