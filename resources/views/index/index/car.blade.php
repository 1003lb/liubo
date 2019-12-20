@extends('layouts.shop')
@section('title', '首页')
@section('content')
  </head>
  <body>
    <div class="maincont">
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>购物车</h1>
      </div>
     </header>
     <div class="head-top">
      <img src="/static/index/images/head.jpg" />
     </div><!--head-top/-->
     <table class="shoucangtab">
      <tr>
       <td width="75%"><span class="hui">购物车共有：<strong class="orange"></strong>件商品</span></td>
       <td width="25%" align="center" style="background:#fff url(/static/index/images/xian.jpg) left center no-repeat;">
        <span class="glyphicon glyphicon-shopping-cart" style="font-size:2rem;color:#666;"></span>
       </td>
      </tr>
     </table>
     
     <div class="dingdanlist">
      <table>
          <a href="javascript:;">
              <input type="checkbox"  class="allBox"/> 全选
          </a>
          @foreach($cartInfo as $v)
       <tr goods_id="{{$v->goods_id}}">

       </tr>
       <tr>
        <td width="4%"><input type="checkbox" class="box"/></td>
        <td class="dingimg" width="15%"><img src="{{env('UPLOAD_URL')}}{{$v->goods_img}}" /></td>
        <td width="50%">
         <h3>{{$v->goods_name}}</h3>
         <time>{{date("Y-m-d H:i:s",$v->add_time)}}</time>
        </td>
        <td align="right" goods_num="{{$v->goods_num}}">
            
                <input type="button" class="less" value="-">
                <input type="text" value="{{$v->buy_number}}"  />
                <input type="button"  class="add" value="+">
          
        </td>
         <td><strong class="orange">¥{{$v->goods_price*$v->buy_number}}</strong></td>
           <td><a href="javascript:;" class="del">删除</a></td>
       </tr>
       <tr>
       
       </tr>
          @endforeach

      </table>
     </div><!--dingdanlist/-->

     <div class="height1"></div>
     <div class="gwcpiao">
     <table>
      <tr>
       <th width="10%"><a href="javascript:history.back(-1)"><span class="glyphicon glyphicon-menu-left"></span></a></th>
       <td width="50%">总计：<strong class="orange" id="money">¥0</strong></td>
       <td width="40%"><a href="javascript:;" class="jiesuan"  >去结算</a></td>
      </tr>
     </table>
    </div><!--gwcpiao/-->
 @endsection

     <table>
      <tr>
       <th width="10%"><a href="javascript:history.back(-1)"><span class="glyphicon glyphicon-menu-left"></span></a></th>
       <td width="50%">总计：<strong class="orange" id="money">¥</strong></td>
       <td width="40%"><a href="javascript:;" class="jiesuan"  >去结算</a></td>
      </tr>
     </table>

<script src="/static/index/js/jquery-3.2.1.min.js"></script>

<script>

  
        //点击加号
        $(document).on('click', '.add', function () {
            var _this=$(this);
            var buy_number=parseInt(_this.prev('input').val());
            var goods_id=_this.parents('tr').prev('tr').attr('goods_id');
            var goods_num=parseInt(_this.parents('td').attr('goods_num'));
            if(buy_number>goods_num){
                _this.prev('input').val(buy_number);
            }else{
                buy_number=buy_number+1;
                _this.prev('input').val(buy_number);

            }
            //点击选中复选框
            _this.parents("tr").find(".box").prop('checked',true);
            //更改购买数量
            changeNum(goods_id,buy_number);
            //获取小计
            getTotal(goods_id,_this);
            //获取总价
            getCount();
          });
        //点击减号
        $(document).on('click', '.less', function () {
              //文本框的值-1
              var _this=$(this);//当前点击的-
              var buy_number=parseInt(_this.next("input").val());//购买数量
              if(buy_number<=1){
                _this.next("input").val(1);
              }else{
                    buy_number=buy_number-1;
                    _this.next("input").val(buy_number);
              }

            //数据库的购买数量为文本框的值 Ajax同步
                var goods_id= _this.parents("tr").attr('goods_id');  
                changeNum(buy_number,goods_id);
                   
                  //给当前行默认选中
                _this.parents("tr").find(".box").prop('checked',true);
                //3、获取小计 ajax
                   getTotal(goods_id,_this);
                //4、重新获取总价 ajax
                  getCount();
        });

        //失去焦点
        $(document).on('click', '.value', function () {
            var _this=$(this);
            var buy_number=_this.val();
            var goods_id=_this.parents('tr').prev('tr').attr('goods_id');
            var goods_num=parseInt(_this.parents('td').attr('goods_num'));
            var reg=/^\d+$/;
            if(!reg.test(buy_number)||buy_number<=0){
                _this.val(1);
                var buy_number=1;
            }else if(parseInt(buy_number)>=parseInt(goods_num)){
                _this.val(goods_num);
            }else{
                buy_number = parseInt(buy_number);
                _this.val(buy_number);
            }
            //更改购买数量
            changeNum(goods_id,buy_number);
            //点击选中复选框
            _this.parents("tr").find(".box").prop('checked',true);

            //获取小计
            getTotal(goods_id,_this);
            //获取总价
            getCount();
        })

        //点击复选框
        $(document).on('click','.box',function () {
            var status=$(this).prop('checked');
            //重新获取总价
            getCount();
        })

        //点击全选
        $(document).on('click','.allBox',function () {
            var status=$(this).prop('checked');
            $('.box').prop('checked',status);

            //重新获取总价
            getCount();
        });

        //点击删除
        $(document).on('click','.del',function () {
            var _this=$(this);
            var goods_id=_this.parents("tr").prev('tr').attr('goods_id');
            //console.log(goods_id);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:"{{url('/del')}}",
                type:'post',
                data:{goods_id:goods_id},
                async:false,
            }).done(function (res) {
                if(res.code==2){
                    alert(res.font);
                }else{
                    _this.parents("tr").remove();
                    $("#money").text('￥'+0);
                }
            })
        });

        //点击结算
        $(document).on('click','.jiesuan',function () {
            var _box=$(".box:checked");
            if(_box.length>0){
                var goods_id="";
                _box.each(function(index){
                    goods_id+=$(this).parents("tr").prev('tr').attr("goods_id")+',';
                })
                goods_id=goods_id.substr(0,goods_id.length-1);
                // console.log(goods_id);
                location.href="{{url('/pay')}}?goods_id="+goods_id;
            }else{
                alert("请至少选中一件商品");
            }
        });

        //更改购买数量
        function changeNum(goods_id,buy_number) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:"{{url('/changeNum')}}",
                type:'post',
                data:{buy_number:buy_number,goods_id:goods_id},
                async:false,
            }).done(function (res) {
                if(res.code==2){
                    alert(res.font);
                }
                // console.log(res);
            })
        }

        //获取小计
        function getTotal(goods_id,_this) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:"{{url('/getTotal')}}",
                type:'post',
                data:{goods_id:goods_id},
                async:false
            }).done(function (res) {
                _this.parents('tr').next('tr').children().text('￥'+res);
            })
        }

        //获取总价
        function getCount(){
            var _box=$(".box:checked");

            var goods_id="";
            _box.each(function (index) {
                goods_id+=$(this).parents('tr').prev('tr').attr('goods_id')+',';
            })
            goods_id=goods_id.substr(0,goods_id.length-1);
            // console.log(goods_id);
            // return false;
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:"{{url('/getCount')}}",
                method:'post',
                data:{goods_id:goods_id},
            }).done(function (res) {
                $("#money").text("￥"+res);
                // console.log(res)
            });
        }
    
</script>