<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
<h2>分类添加</h2>
<!-- @if ($errors->any())
   <div class="alert alert-danger">
   <ul>
   @foreach ($errors->all() as $error)
   <li>{{ $error }}</li>
   @endforeach
   </ul>
   </div>
@endif -->
	<form action="{{url('/cate/store')}}" method="post">
	@csrf
分类名称<input type="text" name="cate_name">
<p style="color:#8d00ff">{{$errors->first('cate_name')}}</p>
<br>
是否展示<input type="radio" name="cate_show" value="1" checked/>是
         <input type="radio" name="cate_show" value="2" />否<br>
是否在导航栏展示
 		<input type="radio" name="cate_nav_show" value="1">是
         <input type="radio" name="cate_nav_show" value="2"  checked>否<br>
         上级分类
         <select name="parent_id">
                           <option>--请选择--</option>
                        @foreach ($cateInfo as $v)
                            <option value="{{$v->cate_id}}">@php echo str_repeat('-',$v['lv'])@endphp {{$v->cate_name}}</option>
                        @endforeach
                        </select><br>
                        <input type="submit" value="提交">
	</form>
</body>
</html>