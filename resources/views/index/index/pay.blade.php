@extends('layouts.shop')
@section('title','富婆俱乐部')
@section('content')
 <header>
  <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
  <div class="head-mid">
   <h1>购物车</h1>
  </div>
 </header>
 <div class="head-top">
  <img src="/static/index/images/head.jpg" />
 </div><!--head-top/-->
 <div class="dingdanlist" >
  <table>
   <tr>
    <td class="dingimg" width="75%" colspan="2"><a href="{{url('/address')}}">新增收货地址</a></td></tr>
   <tr><td colspan="3" style="height:10px; background:#efefef;padding:0;"></td></tr>
   <tr>
 
   </tr>
   <tr><td colspan="3" style="height:10px; background:#efefef;padding:0;"></td></tr>
   <tr>
    <td class="dingimg" width="75%" colspan="2">支付方式</td>
    <td align="right">
     <ul class="pay" id="pay">
      <li class="checked" pay_type="1">支付宝支付</li>
      <li pay_type="2">微信支付<div class="ch_img"></div></li>
      <li pay_type="3">银行卡支付<div class="ch_img"></div></li>
     </ul>

    </td>
   </tr>
   <tr><td colspan="3" style="height:10px; background:#efefef;padding:0;"></td></tr>
   <tr>
    <td class="dingimg" width="75%" colspan="2">优惠券</td>
    <td align="right"><span class="hui">无</span></td>
   </tr>
   <tr><td colspan="3" style="height:10px; background:#efefef;padding:0;"></td></tr>
   <tr>
    <td class="dingimg" width="75%" colspan="2">是否需要开发票</td>
    <td align="right"><a href="javascript:;" class="orange">是</a> &nbsp; <a href="javascript:;">否</a></td>
   </tr>
   <tr>
    <td class="dingimg" width="75%" colspan="2">发票抬头</td>
    <td align="right"><span class="hui">个人</span></td>
   </tr>
   <tr>
    <td class="dingimg" width="75%" colspan="2">发票内容</td>
    <td align="right"><a href="javascript:;" class="hui">请选择发票内容</a></td>
   </tr>
   <tr><td colspan="3" style="height:10px; background:#fff;padding:0;"></td></tr>
   <tr>
    <td class="dingimg" width="75%" colspan="3">商品清单</td>
   </tr>
@foreach($goodsInfo as $v)
   <tr goods_id="{{$v->goods_id}}">
    <td class="dingimg" width="15%"><img src="{{env('UPLOAD_URL')}}{{$v->goods_img}}" /></td>
    <td width="50%">
     <h3>{{$v->goods_name}}</h3>
     <time>下单时间：{{date("Y-m-d H:i:s",$v->add_time)}}</time>
    </td>
    <td align="right"><span class="qingdan">X {{$v->buy_number}}</span></td>
   </tr>

   <tr>
    <th colspan="3"><strong class="orange">¥{{$v->goods_price}}</strong></th>
   </tr>
   @endforeach
   <tr>
    <td class="dingimg" width="75%" colspan="2">商品金额</td>
    <td align="right"><strong class="orange">¥{{$count}}</strong></td>
   </tr>
   <tr>
    <td class="dingimg" width="75%" colspan="2">折扣优惠</td>
    <td align="right"><strong class="green">¥0.00</strong></td>
   </tr>
   <tr>
    <td class="dingimg" width="75%" colspan="2">抵扣金额</td>
    <td align="right"><strong class="green">¥0.00</strong></td>
   </tr>
   <tr>
    <td class="dingimg" width="75%" colspan="2">运费</td>
    <td align="right"><strong class="orange">¥0</strong></td>
   </tr>
  </table>
 </div><!--dingdanlist/-->


</div><!--content/-->

<div class="height1"></div>
<div class="gwcpiao">
 <table>
  <tr>
   <th width="10%"><a href="javascript:history.back(-1)"><span class="glyphicon glyphicon-menu-left"></span></a></th>
   <td width="50%">总计：<strong class="orange">¥{{$count}}</strong></td>
   <td width="40%"><a href="javascript:;" class="jiesuan" id="success">提交订单</a></td>
  </tr>
 </table>
</div><!--gwcpiao/-->
@endsection


 <table>
  <tr>
   <th width="10%"><a href="javascript:history.back(-1)"><span class="glyphicon glyphicon-menu-left"></span></a></th>
   <td width="50%">总计：<strong class="orange">¥{{$count}}</strong></td>
   <td width="40%"><a href="javascript:;" class="jiesuan" id="success">提交订单</a></td>
  </tr>
 </table>

<script src="/static/index/js/jquery-3.2.1.min.js"></script>

<script>
     
         $(document).on('click','.pay>li',function(){
          $(this).addClass('checked').siblings('li').removeClass('checked');
         });
         $(document).on('click','#success',function () {
             var _tr=$("tr[goods_id]");
             var goods_id="";
             _tr.each(function (index) {
                 goods_id+=$(this).attr('goods_id')+',';
             });
          goods_id=goods_id.substr(0,goods_id.length-1);

          var pay_type=$("li[class='checked']").attr('pay_type');
         // console.log(pay_type)

        location.href="{{url('/submitOrder')}}?goods_id="+goods_id+"&pay_type="+pay_type;
         })
</script>