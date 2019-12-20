<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>

<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<h1>文章列表</h1>
<script src="/static/admin/js/jquery-3.2.1.min.js"></script>
<form action="" method="">

@csrf
	标题<input type="text" name="a_name" value="{{$query['a_name']??''}}">
	分类<select name="cate_id">
	<option value="">--请选择--</option>
	@foreach ($CateInfo as $v)
	<option value="{{$v['cate_id']}}">{{$v['cate_name']}}</option>
	@endforeach
	</select>
	<input type="submit" value="搜索">
</form>
<h3><a href="{{url('/article/create')}}">添加</a></h3>
<b style="color:#8d00ff">{{session('msg')}}</b>
<table border="3">
<tr>
	<td>编号</td>
	<td>文章标题</td>
	<td>文章分类</td>
	<td>文章重要性</td>
	<td>是否显示</td>
	<td>添加时间</td>
	<td>作者</td>
	<td>作者邮箱</td>
	
	<td>操作</td>
</tr>
@foreach ($data as $v)
<tr>
	<td>{{$v->a_id}}</td>
	<td>{{$v->a_name}}</td>
	<td>{{$v->cate_name}}</td>
	<td>{{$v->is_zy==1?'是':'否'}}</td>
	<td>{{$v->is_xs==1?'是':'否'}}</td>
	<td>{{date("Y-m-d H:i:s")}}</td>
	<td>{{$v->name}}</td>
	<td>{{$v->email}}</td>
	<td>
	<a href="javascript:void(0)" a_id="{{$v->a_id}}" class="del">删除</a>
	<a href="{{url('/article/edit/'.$v->a_id)}}">修改</a>
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
	var a_id= $(this).attr('a_id');
	if(confirm('确认删除此条记录吗')){
		$.post("{{url('article/delete')}}",{a_id:a_id},function(data){
			if(data.code=='00000'){
				alert(data.msg);
				window.location.reload();
			}
		},'json');
	}
});

</script>