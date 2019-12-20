<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
<h1 ><a style="color:#16b3ff" href="{{url('/brand/index')}}">品牌表 | </a><a style="color:#16b3ff" href="{{url('/cate/index')}}">分类表 | </a><a style="color:#16b3ff" href="{{url('/admin/index')}}">管理员表</a></h1>
<h1>商品列表</h1>

<form action="">
<input type="text" name="goods_name" value="{{$query['goods_name']??''}}">
<input type="submit" value="搜索">
</form>
<h3><a href="{{url('/goods/create')}}">添加·</a></h3>
<b style="color:#8d00ff">{{session('msg')}}</b>
<b style="color:#8d00ff">{{session('sq')}}</b>
	<table border="7">
	<tr>
	<td>商品名</td>
	<td>商品价格</td>
	<td>商品数量</td>
	<td>商品图片</td>
	<td>商品相册</td>
	<td>所属分类</td>
	<td>所属品牌</td>
	<td>操作</td>
	</tr>
	  @foreach ($data as $v)
	<tr>
	<td>{{$v->goods_name}}</td>
	<td>{{$v->goods_price}}</td>
	<td>{{$v->goods_num}}</td>
	<td><img src="{{env('UPLOAD_URL')}}{{$v->goods_img}}" width="80"></td>
	<td>
		@foreach ($v->goods_imgs as $vv)
		<img src="{{env('UPLOAD_URL')}}{{$vv}}" width="80">
		@endforeach
	</td>
	<td>{{$v->cate_name}}</td>
	<td>{{$v->brand_name}}</td>
	
	<td>
<a href="{{url('/goods/delete/'.$v->goods_id)}}">删除</a>
<a href="{{url('/goods/edit/'.$v->goods_id)}}">修改</a>
	</td>

	</tr>
  @endforeach
	</table>
	{{$data->appends($query)->links()}}
</body>
</html>