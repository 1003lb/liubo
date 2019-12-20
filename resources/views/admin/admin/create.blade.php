<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
<h2>管理员添加</h2>
<!-- //复制粘贴 -->
<!-- @if ($errors->any())
	<div class="alert alert-danger">
	<ul>
	@foreach ($errors->all() as $error)
	<li>{{ $error }}</li>
	@endforeach
	</ul>
	</div>
@endif -->
<form action="{{url('/admin/store')}}" method="post"  enctype="multipart/form-data">
			@csrf
	姓名<input type="text" name="a_name">
<p style="color:#8d00ff">{{$errors->first('admin_name')}}</p>
	<br>
	头像<input type="file" name="a_img"><br>
	年龄<input type="text" name="a_age"><br>
	性别<input type="radio" name="a_sex" value="1">女
	<input type="radio" name="a_sex"  value="2">男<br>
	邮箱<input type="email" name="email"><br>
	密码<input type="password" name="pwd">
	<p style="color:#8d00ff">{{$errors->first('pwd')}}</p>
	<br>
	<input type="submit" value="提交">

	</form>
</body>
</html>