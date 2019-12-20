<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
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
	<form action="{{url('/brand/store')}}" method="post" enctype="multipart/form-data">
	@csrf
	 品牌名称<input type="text" name="brand_name"> 
<!-- 复制粘贴 -->
<p style="color:#8d00ff">{{$errors->first('brand_name')}}</p>
	<br>
	品牌logo<input type="file" name="brand_logo">
<!-- 复制粘贴 -->
	<p style="color:#8d00ff">{{$errors->first('brand_url')}}</p>
	<br>
	品牌网址<input type="text" name="brand_url"><br>
	品牌描述<textarea name="brand_desc" ></textarea><br>
	<input type="submit" value="提交">
	</form>
</body>
</html>