<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
<h1 ><a style="color:#16b3ff" href="{{url('/goods/index')}}">商品表 | </a><a style="color:#16b3ff" href="{{url('/brand/index')}}">品牌表 | </a><a style="color:#16b3ff" href="{{url('/admin/index')}}">管理员表</a></h1>
<h1>分类展示页面</h1>
<h3><a href="{{url('/cate/create')}}">添加</a></h3>
<form action="">
<input type="text" name="cate_name" value="{{$query['cate_name']??''}}" placeholder="请输入名称关键字">
<input type="submit" value="搜索">
</form>
<b style="color:#8d00ff">{{session('msg')}}</b>

	<table border="4">
	<tr>
	<td>分类ID</td>
	<td>分类名称</td>
	<td>是否展示</td>
	<td>是否在导航栏展示</td>
	<td>状态</td>
	</tr>
	@foreach ($data as $v)
	<tr>
	<td>{{$v->cate_id}}</td>
	<td>{{$v->cate_name}}</td>
     <td>{{$v->cate_show==1?'是':'否'}}</td>
     <td>{{$v->cate_nav_show==1?'是':'否'}}</td>
	<td>
<a href="{{url('/cate/delete/'.$v->cate_id)}}">删除</a>
<a href="{{url('/cate/edit/'.$v->cate_id)}}">修改</a>
</td>
	@endforeach
	</tr>
	</table>
	{{$data->appends($query)->links()}}
</body>
</html>