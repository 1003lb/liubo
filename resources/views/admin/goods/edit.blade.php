<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<h2>修改页面</h2>
		<form action="{{url('/goods/update/'.$goodsInfo->goods_id)}}" method="post" enctype="multipart/form-data">
	@csrf	
	商品名称<input type="text" name="goods_name" value="{{$goodsInfo->goods_name}}"><br>
	商品价格<input type="text" name="goods_price" value="{{$goodsInfo->goods_price}}"><br>
	商品库存<input type="text" name="goods_num" value="{{$goodsInfo->goods_num}}"><br>
	所属分类<select name="cate_id">
                            <option>--请选择--</option>
                        @foreach ($info as $v)
                            <option value="{{$v['cate_id']}}">@php echo str_repeat('&nbsp;&nbsp;',$v['lv']*3)@endphp {{$v['cate_name']}}</option>
                        @endforeach
                        </select><br>
    商品品牌 <select name="brand_id">
							@foreach ($BInfo as $v)
								<option value="{{$v['brand_id']}}">{{$v['brand_name']}}</option>
							@endforeach
							</select><br>

		商品图片	<input type="file" name="goods_img"/><img src="{{env('UPLOAD_URL')}}{{$goodsInfo->goods_img}}" width="80" ><br>
		<input type="submit" value="提交">
	</form>
</body>
</html>