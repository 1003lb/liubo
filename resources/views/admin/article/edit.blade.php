<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
<h1>修改文章</h1>
	<form action="{{url('/article/update/'.$article->a_id)}}" method="post" enctype="multipart/form-data">
		@csrf
		文章标题<input type="text" name="a_name" value="{{$article->a_name}}"><br>
	文章分类<select name="cate_id">
		<option value="">--请选择--</option>
		@foreach ($cate as $v)
		<option value="{{$v['cate_id']}}">{{$v['cate_name']}}</option>
		@endforeach
	</select><br>
	文章重要性<input type="radio" name="is_zy" value="1" checked>是
			<input type="radio" name="is_zy" value="2">否<br>

	是否显示<input type="radio" name="is_xs" value="1" checked>是
			<input type="radio" name="is_xs" value="2">否<br>
	
	作者<input type="text" name="name" value="{{$article->name}}" ><br>
	作者邮箱<input type="email" name="email"  value="{{$article->email}}"><br>
	网页介绍<textarea name="a_desc" id="" cols="30" rows="10"> {{$article->a_desc}}"</textarea><br>
	上传文件<input type="file" name="a_img"><br>
	<input type="submit" value="提交">
	</form>
</body>
</html>