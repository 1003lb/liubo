<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<h1 ><a style="color:#16b3ff" href="{{url('/goods/index')}}">商品表 | </a><a style="color:#16b3ff" href="{{url('/cate/index')}}">分类表 | </a><a style="color:#16b3ff" href="{{url('/admin/index')}}">管理员表</a></h1>
<h2>列表展示</h2>
<script src="/static/admin/js/jquery-3.2.1.min.js"></script>

<form action="" method="">
	<input type="text" name="brand_name" value="{{$query['brand_name']??''}}">
	<input type="text" name="brand_url" value="{{$query['brand_url']??''}}">
	<input type="submit" value="搜索">
</form>
<h4><a href="{{url('/brand/create')}}">添加</a></h4>
<b style="color:#8d00ff">{{session('msg')}}</b>
<b style="color:#8d00ff">{{session('ms')}}</b>

	<table border="4">
	
	<tr>
		<td>品牌名称</td>
		<td>品牌logo</td>
		<td>品牌网址</td>
		<td>品牌描述</td>
		<td>操作</td>
	</tr>
	@foreach ($data as $v)
	<tr>
		<td>{{$v->brand_name}}</td>
		<td><img src="{{env('UPLOAD_URL')}}{{$v->brand_logo}}" width="100"></td>
		<td>{{$v->brand_url}}</td>
		<td>{{$v->brand_desc}}</td>
		<td>	
		<a href="javascript:void(0)" brand_id="{{$v->brand_id}}" class="del">删除</a>
		<a href="{{url('/brand/edit/'.$v->brand_id)}}" class="btn btn-primary">修改</a>
</td>
	</tr>
@endforeach
	</table>
	{{$data->appends($query)->links()}}

</body>
</html>
<script>
//ajax删除
$.ajaxSetup({
 headers: {
 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
 }
});
$(document).on('click','.del',function(){
	var brand_id=$(this).attr('brand_id');
	//alert(a_id);
if(confirm('确认删除此条记录吗？')){
	$.post("{{url('brand/delete')}}",{brand_id:brand_id},function(data){
		if(data==1){
			alert("删除成功");
			window.location.reload();
			}
		});
	}
});
</script>