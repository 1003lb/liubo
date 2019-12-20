<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<h3>修改</h3>
	<form action="{{url('/brand/update/'.$data->brand_id)}}" method="post" enctype="multipart/form-data">
	@csrf
	品牌名称<input type="text" name="brand_name" value="{{$data->brand_name}}">
<p style="color:#8d00ff">{{$errors->first('brand_name')}}</p>
<br>
	品牌logo<input type="file" name="brand_logo" value="{{$data->brand_logo}}">
	<img src="{{env('UPLOAD_URL')}}{{$data->brand_logo}}" width="100">
	<p style="color:#8d00ff">{{$errors->first('brand_url')}}</p>

	<br>
	品牌网址<input type="text" name="brand_url" value="{{$data->brand_url}}"><br>
	品牌描述<textarea name="brand_desc" value="">{{$data->brand_desc}}</textarea><br>
	<input type="submit" value="提交">
	</form>
</body>
</html>