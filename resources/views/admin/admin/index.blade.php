<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
<h1 ><a style="color:#16b3ff" href="{{url('/goods/index')}}">商品表 | </a><a style="color:#16b3ff" href="{{url('/cate/index')}}">分类表 | </a><a style="color:#16b3ff" href="{{url('/brand/index')}}">品牌表</a></h1>
<h1>管理员列表</h1>
<form action=""> 

<input type="text" name="a_name" value="{{$query['a_name']??''}}">

<input type="submit" value="搜索">
</form>
<h3><a href="{{url('/admin/create')}}">添加</a></h3> 
<b style="color:#8d00ff">{{session('msg')}}</b>
<b style="color:#8d00ff">{{session('sq')}}</b>
	<table border="7">
	<tr>
	<td>管理员姓名</td>
	<td>管理员头像</td>
	<td>管理员年龄</td>
	<td>管理员性别</td>
	<td>管理员邮箱</td>
	<td>管理员密码</td>
	<td>操作</td>
	</tr>
	@foreach ($data as $v)
	<tr>
	<td>{{$v->a_name}}</td>
	<td><img src="{{env('UPLOAD_URL')}}{{$v->a_img}}" width="100"></td>
	<td>{{$v->a_age}}</td>
	<td>{{$v->a_sex==1?'女':'男'}}</td>
	<td>{{$v->email}}</td>
	<td>{{$v->pwd}}</td>
	<td>
	<a href="{{url('/admin/delete/'.$v->a_id)}}">删除</a>
	<a href="{{url('/admin/edit/'.$v->a_id)}}">修改</a>
	</td>
	</tr>
@endforeach
	</table>
	{{$data->appends($query)->links()}}
</body>
</html>