<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
<h1>添加文章</h1>

<script src="/static/admin/js/jquery-3.2.1.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
	<form action="{{url('/article/store')}}" method="post" enctype="multipart/form-data" class="form-horizontal">
		@csrf
		文章标题<input type="text" name="a_name" id="firstname">
		<p style="color:#8d00ff">{{$errors->first('a_name')}}</p>
		<br>
	文章分类<select name="cate_id">
		<option value="">--请选择--</option>
		@foreach ($CateInfo as $v)
		<option value="{{$v['cate_id']}}">{{$v['cate_name']}}</option>
		@endforeach
	</select><br>
	文章重要性<input type="radio" name="is_zy" value="1" checked>是
			<input type="radio" name="is_zy" value="2">否<br>

	是否显示<input type="radio" name="is_xs" value="1" checked>是
			<input type="radio" name="is_xs" value="2">否<br>
	
	作者<input type="text" name="name" id="lastname">
	<p style="color:#8d00ff">{{$errors->first('name')}}</p>
	<br>
	作者邮箱<input type="email" name="email"><br>
	网页介绍<textarea name="a_desc" id="" cols="30" rows="10"></textarea><br>
	上传文件<input type="file" name="a_img"><br>
	<input type="button" value="提交" class="btn-default">
	</form>
</body>
</html>
<script>
	$('#firstname').blur(function(){
		checName();
 
 });

	$('input[name="name"]').blur(function(){
		checkUrl();
	});

	$('.btn-default').click(function(){
		//文章标题
		var NameFlag= checName();
		
		//作者名称
		var UrlFlay= checkUrl();

		//提交
		if(NameFlag && UrlFlay){
			//alert(123);
		$('.form-horizontal').submit();
		}
		//return false;
	});
	function checkUrl(){
		$('input[name="name"]').next().text('');
		 var name=$('input[name="name"]').val();
		 var reg=/^[\u4e00-\u9fa5\w]{2,12}$/;
		 //alert(reg.test(name));
		if(!reg.test(name)){
			$('input[name="name"]').next().text('作者昵称可以是中文,数字,下划线,字母长度2-12位');
			return false;
		}
		return true;
	}

	function checName(){
	$('#firstname').next().text('');
		var a_name=$('#firstname').val();
		var reg=/^[\u4e00-\u9fa5\w]{2,12}$/;
		if(!reg.test(a_name)){
			$('#firstname').next().text('名称必须是中文数字下划线字母长度2-12位');
			return false;
		}
		return checkOnly(a_name);
	}
	function checkOnly(a_name){
		$.ajaxSetup({
 		headers: {
 		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
 		}
});
		var flag=true;
		//唯一性验证
	$.ajax({
			  method: "POST",
		 	 url: "{{url('/article/checkonly')}}",
		 	 async:false,
		  	data: {a_name:a_name}
			}).done(function( msg ) {
		  	if(msg>0){
		  		$('#firstname').next().text('名称已存在');
		  		flag=false;
		  	}
		});
			
			return flag;
	}
</script>