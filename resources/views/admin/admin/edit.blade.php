<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<h2>管理员添加</h2>
<form action="{{url('/admin/update/'.$data->a_id)}}" method="post" enctype="multipart/form-data">
			@csrf
	姓名<input type="text" name="a_name" value="{{$data->a_name}}"><br>
	头像<input type="file" name="a_img" value="{{$data->brand_logo}}">
	<img src="{{env('UPLOAD_URL')}}{{$data->brand_logo}}" width="100"><br>
	年龄<input type="text" name="a_age" value="{{$data->a_age}}"><br>
	性别<input type="radio" name="a_sex" value="1">女
	<input type="radio" name="a_sex"  value="2">男<br>
	邮箱<input type="email" name="email" value="{{$data->email}}"><br>
	密码<input type="password" name="pwd" value="{{$data->pwd}}"><br>
	<input type="submit" value="提交">

	</form>
</body>
</html>