<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
<h1>商品添加</h1>
	<form action="{{url('/goods/store')}}" method="post" enctype="multipart/form-data">
	@csrf	
	商品名称<input type="text" name="goods_name">
	<p style="color:#8d00ff">{{$errors->first('goods_name')}}</p>
<br>
	商品价格<input type="text" name="goods_price">
	<p style="color:#8d00ff">{{$errors->first('goods_price')}}</p>
<br>
	商品库存<input type="text" name="goods_num">
	<p style="color:#8d00ff">{{$errors->first('goods_num')}}</p>
<br>
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

		商品图片	<input type="file" name="goods_img"/><br>
		商品相册<input type="file" name="goods_imgs[]"/>
			<input type="file" name="goods_imgs[]"/>
			<input type="file" name="goods_imgs[]"/><br>
		<input type="submit" value="提交">
	</form>
	
</body>
</html>