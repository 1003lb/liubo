@extends('layouts.shop')
@section('title', '首页')
@section('content')
  </head>
  <body>
    <div class="maincont">
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>产品详情</h1>
      </div>
</header>
     <div id="sliderA" class="slider" value="{{$goodsInfo->goods_img}}">
      <img src="{{env('UPLOAD_URL')}}{{$goodsInfo->goods_img}}" />
      
     </div><!--sliderA/-->
     <table class="jia-len">
      <tr>
       <th><strong class="orange">￥{{$goodsInfo->goods_price}}</strong></th>
       <td> 
        购买数量  <button class="decrease" id="add">+</button>
           <input type="text" value="1" id="buy_number" >{{session('msg')}}
           <button class="decrease" id="less">-</button>

       </td>
      </tr>
      <tr>
       <td><a id='addCart' href="javascript:;">加入购物车</a></td>
       <td>
        <strong>{{$goodsInfo->goods_name}}</strong>
        <p class="hui">七天无理由退换</p>
       </td>
       <td align="right">
        <a href="javascript:;" class="shoucang"><span class="glyphicon glyphicon-star-empty"></span></a>
       </td>
      </tr>
     </table>
  
     <div class="height2"></div>
     <div class="zhaieq">
      <a href="javascript:;" class="zhaiCur">商品简介</a>
      <a href="javascript:;">商品参数</a>
      <a href="javascript:;" style="background:none;">订购列表</a>
      <div class="clearfix"></div>
     </div><!--zhaieq/-->
     <div class="proinfoList">
  <img src="{{env('UPLOAD_URL')}}{{$goodsInfo->goods_img}}" width="400">
     </div><!--proinfoList/-->
    <div class="proinfoList">
   </div>
     <div class="proinfoList">
    
     </div><!--proinfoList/-->
     <table class="jrgwc">
      <tr>
       <th>
        <a href="{{url('/index')}}"><span class="glyphicon glyphicon-home">回到首页</span></a>
       </th>
      
      </tr>
     </table>
    </div><!--maincont-->
    @endsection

  <script src="/static/index/js/jquery-3.2.1.min.js"></script>

<script>

    
        $(document).on('click','#add',function () {
            var goods_num=parseInt($("#goods_num").val());//获取库存
            //alert(goods_num);
           var buy_number=parseInt($("#buy_number").val());//获取文本框的值
           //alert(buy_number);
            buy_number=parseInt(buy_number);
            if(buy_number>=goods_num){ 
             $("#buy_number").val(goods_num);
                 }else{
                var buy_number=buy_number+1;
                $("#buy_number").val(buy_number);
            }

        });

        //点击减号
        $(document).on('click','#less',function () {
            var buy_number=parseInt($("#buy_number").val());//获取文本框的值
            if(buy_number<=1){
                $("#buy_number").val(1);
            }else{
                var buy_number=buy_number-1;
                $("#buy_number").val(buy_number);
            }
        })

        //失去焦点
        $(document).on('blur','#buy_number',function () {
            var goods_num=parseInt($("#goods_num").val());//获取库存
            var buy_number=parseInt($("#buy_number").val());//获取文本框的值

            //检测是否是数字
            var reg= /^\d+$/;
            if(!reg.test(buy_number)||parseInt(buy_number)<=0){
                $("#buy_number").val(1);
            }else if(parseInt(buy_number)>=goods_num){
                $("#buy_number").val(goods_num);
            }else{
                buy_number=parseInt(buy_number);
                $("#buy_number").val(buy_number);
            }
        })

        //加入购物车
        $(document).on("click","#addCart",function () {
            var buy_number=$("#buy_number").val();
            //console.log(buy_number);
            var goods_id="{{$goodsInfo->goods_id}}";
            var goods_price="{{$goodsInfo->goods_price}}";
                   $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:"{{url('/carAdd')}}",
                type:'post',
                data:{goods_id:goods_id,buy_number:buy_number,goods_price:goods_price},
                async:false,
            }).done(function (res) {
                  if(res==1){
                    location.href="{{url('/cartList')}}";
                  }else{
                          location.href="{{url('/car')}}";
                  }
            })
        });
  


</script>