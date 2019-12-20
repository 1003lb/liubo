
@extends('layouts.shop')
@section('title', '注册')
@section('content')
     </header>
     <div class="head-top">
      <img src="/static/index/images/head.jpg" />
     </div><!--head-top/-->
     <form action="{{url('/doreg')}}" method="get" class="reg-login">
     @csrf
      <h3>已经有账号了？点此<a class="orange" href="{{url('/login')}}">登陆</a></h3>
      <div class="lrBox">
       <div class="lrList"><input type="text" placeholder="输入邮箱号" name="email" />
      <p style="color:#8d00ff">{{$errors->first('email')}}</p>
       </div>
       <div class="lrList2"><input type="text" placeholder="输入邮箱验证码" name="tel" /> <button id="checkCode" >获取验证码</button>
<p style="color:#8d00ff">{{$errors->first('tel')}}</p>
       </div>
       <div class="lrList"><input type="text" placeholder="设置新密码（6-18位数字或字母）" name="pwd" />
  <p style="color:#8d00ff">{{$errors->first('pwd')}}</p>
       </div>
       <div class="lrList"><input type="text" placeholder="再次输入密码" name="code" /></div>
      </div><!--lrBox/-->
      <div class="lrSub">
       <input type="submit" value="立即注册" />
      </div>
     </form><!--reg-login/-->
      @endsection

 <script src="{{asset('/static/admin/js/jquery-3.2.1.min.js')}}"></script>
<script>
  
     $(document).on('click','#checkCode',function(){
            //alert(111);
      var email=$("div[class='lrList']").children().val();
             //alert(email);
        var reg=/^\w+@\w+\.com$/;
        if(email==''){
          alert('邮箱不能为空');
          return false;
        }else if(!reg.test(email)){
          alert('邮箱格式有误');
          return false;
        }
         $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:"{{url('/login/send')}}",
                method:'post',
                data:{email:email},
                dataType:'json'
            }).done(function (res) {
                // console.log(res);
                if(res.code==1){
                    alert(res.font)
                }else{
                    alert(res.font)
                }
            });
            return false;
        });
    

</script>