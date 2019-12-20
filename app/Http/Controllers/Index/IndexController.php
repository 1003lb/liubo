<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Goods;
use App\Model\Cate;
use App\Model\Cart;
use App\Model\Order;
use App\Model\OrderGoods;
use DB;
class IndexController extends Controller
{
	//前台首页
    public function index(){
		$goodsInfo=Goods::get();
		//dd($res);
		  $data = Cate::where('parent_id','=',0)->get();
        $cateInfo = $this->get_cate($data);
		return view('index.index.index',['goodsInfo'=>$goodsInfo,'cateInfo'=>$cateInfo]); 
    }

       //无限级分类
    function get_cate($res,$parent_id=0,$lv=1)
    {
        static  $array =[];
        foreach($res as $v){
            if($v['parent_id']==$parent_id){
                $v['lv'] =$lv;
                $array[]=$v;    
                $this->get_cate($res,$v['cate_id'],$v['lv']+1);
            }
        }
        return $array;
    }
//用户
 public function user(){
		return view('index.index.user'); 
    }
//商品展示页面
    public function proinfo($id){
    	$goodsInfo=Goods::where('goods_id',$id)->first();
    	//dd($goodsInfo);
    	return view('index.index.proinfo',['goodsInfo'=>$goodsInfo]); 
    }
//分类展示页面
  public function prolist($id){

$cateInfo=Cate::get();
//dd($cateInfo);
$cateInfo=getCateId($cateInfo,$id);
// dd($cateInfo);
  $goodsInfo=Goods::select('goods_id','goods_name','goods_price','goods_img')->whereIn('cate_id',$cateInfo)->get();
  // dd($goodsInfo);
return view('index.index.prolist',['goodsInfo'=>$goodsInfo]);

  }

public function car(){
   
                return redirect('/car');
            
     //return view('index.index.car',['goodsInfo'=>$goodsInfo]); 
}
public function carAdd(){

         $goods_id=request()->goods_id;
        $buy_number=request()->buy_number;
        $add_price=request()->goods_price;
    ///dd($buy_number);
        $user=session('user');
        $user_id=$user['user_id'];


   $cartInfo=Cart::where('goods_id',$goods_id)->first();

     if(empty($cartInfo)){

                $arr=['user_id'=>$user_id,'goods_id'=>$goods_id,'buy_number'=>$buy_number,'add_time'=>time(),'add_price'=>$add_price];
                $info=Cart::insert($arr);
                //dd($info);
                if($info){
                    echo 1;
                }
        }else{
                $buy_number=$buy_number+$cartInfo['buy_number'];
            $res=Cart::where('goods_id',$goods_id)->update(['buy_number'=>$buy_number,'add_time'=>time(),'add_price'=>$add_price]);

            if($res){
                echo 1;
              }else{
                echo 2;
              }
        }
}
public function cartList(){
    $where=[
        [ 'is_del',"=",1],
    ];
     $cartInfo = Cart::join("goods", "goods.goods_id", "=", "cart.goods_id")
                ->where($where)  
                ->orderBy('add_time', 'desc')
                ->get();
      //dd($cartInfo);
            ///cache(['cartInfo' => $cartInfo], 10);
    

        return view('index.index.car',['cartInfo'=>$cartInfo]);
    }
    
    //获取总价
    public function getCount(){
    
            $goods_id = request()->goods_id;
            $goods_id = explode(',', $goods_id);
//        print_r($goods_id);die;
//        echo $goods_id;die;
            $user = session('user');
            $user_id = $user['user_id'];

//        print_r($where);die;
            $goodsInfo = Cart::join('goods', 'cart.goods_id', '=', 'goods.goods_id')
                ->whereIn('goods.goods_id', $goods_id)
                ->where('user_id', $user_id)
                ->get();
            //cache(['goodsInfo' => $goodsInfo], 5);
      
            $money=0;
        foreach($goodsInfo as $k=>$v){
            $money+=$v['goods_price']*$v['buy_number'];
        }
        return $money;
    }

    //更改购买数量
    public function changeNum(){
        $buy_number=request()->buy_number;
        $goods_id=request()->goods_id;
        $user=session('user');
        $user_id=$user['user_id'];
        $where=[
            ['user_id','=',$user_id],
            ['goods_id','=',$goods_id],
            ['is_del','=',1]
        ];
        $res=Cart::where($where)->update(['buy_number'=>$buy_number]);
//        echo $res;die;
        if($res){
            echo json_encode(['font'=>'','code'=>1]);
        }else{
            echo json_encode(['font'=>'更改购买数量失败','code'=>2]);die;
        }
    }

    //获取小计
    public function getTotal(){
     
            $goods_id = request()->goods_id;
//        echo $goods_id;
            $user = session('user');
            $user_id = $user['user_id'];
            $where = [
                ['user_id', '=', $user_id],
                ['goods.goods_id', '=', $goods_id],
                ['is_del', '=', 1]
            ];
            $goodsInfo = Cart::join('goods', 'cart.goods_id', '=', 'goods.goods_id')
                ->select('goods_price', 'buy_number')
                ->where($where)
                ->first();
          
    
        $total=$goodsInfo['goods_price']*$goodsInfo['buy_number'];
        echo $total;
    }

    //删除
    public function del(){
        $goods_id=request()->goods_id;

//        echo $goods_id;die;
        $res=Cart::where('goods_id',$goods_id)->update(['is_del'=>2]);
        if($res){
            echo json_encode(['font'=>'','code'=>1]);
        }else{
            echo json_encode(['font'=>'删除失败','code'=>2]);die;
        }
    }

    //
    public function pay(){
      
            $goods_id = request()->goods_id;
//        echo $goods_id;
            $goods_id = explode(',', $goods_id);
//        print_r($goods_id);die;
            $goodsInfo = Cart::join('goods', 'cart.goods_id', '=', 'goods.goods_id')
                ->whereIn('cart.goods_id', $goods_id)
                ->where('is_del', 1)
                ->get();
//        dd($goodsInfo);
            cache(['goodsInfo' => $goodsInfo], 10);
       
        $count=0;
        foreach($goodsInfo as $k=>$v){
            $count+=$v['buy_number']*$v['goods_price'];
        }
        return view('index/index/pay',['goodsInfo'=>$goodsInfo,'count'=>$count]);
    }

   public  function address(){

   }
    function submitOrder(){
    $goods_id = request()->goods_id;
            $goods_id = explode(',', $goods_id);
            $pay_type = request()->pay_type;

            $user = session('user');
            $user_id = $user['user_id'];
            $where = [
                ['user_id', '=', $user_id],
                ['is_del', '=', 1]
            ];
            $goodsInfo = Cart::join('goods', 'goods.goods_id', '=', 'cart.goods_id')
                ->whereIn('cart.goods_id', $goods_id)
                ->where($where)
                ->select('goods.goods_id', 'goods_name', 'goods_img', 'goods_price', 'buy_number')
                ->get();
//            dd($goodsInfo);'
          
            $order_amount=0;
            foreach($goodsInfo as $v){
                $order_amount+=$v['goods_price']*$v['buy_number'];
            }
//            echo $order_amount;die;
        $orderInfo['order_number']=time().rand(100000,999999);
        $orderInfo['user_id']=$user_id;
        $orderInfo['order_amount']=$order_amount;
        $orderInfo['pay_type']=$pay_type;
        $orderInfo['create_time']=time();
        $order_id=Order::insertGetId($orderInfo);
//        print_r($order_id);die;
        if(empty($order_id)){
            echo "订单表数据添加失败";die;
        }

        foreach($goodsInfo as $k=>$v){
            $goodsInfo[$k]['user_id']=$user_id;
            $goodsInfo[$k]['order_id']=$order_id;
        }
        $goodsInfo=$goodsInfo->toArray();
        $res=DB::table('order_goods')->insert($goodsInfo);
//        dd($res);
        if(empty($res)){
            echo "订单商品表添加失败";die;
        }

        $res=Cart::whereIn('goods_id',$goods_id)->where($where)->update(['is_del'=>2]);
        if(empty($res)){
            echo '清除购物车数据失败';die;
        }

        echo "<script>location.href='".url('/success')."?order_id=$order_id';</script>";
    }

    function success(){
        $orderInfo=cache('orderInfo');
        if(!$orderInfo) {
            $order_id = request()->order_id;
//        echo $order_id;
            $user = session('user');
            $user_id = $user['user_id'];
            $where = [
                ['order_id', '=', $order_id],
                ['user_id', '=', $user_id]
            ];
            $orderInfo = Order::where($where)->first();
           
        }
        return view('index/index/success',['orderInfo'=>$orderInfo]);
    }
    //发起手机支付

public function pays($order_id){
          //根据订单id查询订单号和订单金额
        $order=DB::table('order')->select('order_number','order_amount')->where('order_id',$order_id)->first();

   require_once app_path('lib/alipay/wappay/service/AlipayTradeService.php');
    require_once app_path('lib/alipay/wappay/buildermodel/AlipayTradeWapPayContentBuilder.php');
   $config=config('alipay');

    if (!empty($order->order_number&& trim($order->order_number)!="")){
        //商户订单号，商户网站订单系统中唯一订单号，必填
        $out_trade_no = $order->order_number;

        //订单名称，必填
        $subject ='富婆俱乐部欢迎您';

        //付款金额，必填
        $total_amount = $order->order_amount;

        //商品描述，可空
        $body = "";

        //超时时间
        $timeout_express="1m";

        $payRequestBuilder = new \AlipayTradeWapPayContentBuilder();
        $payRequestBuilder->setBody($body);
        $payRequestBuilder->setSubject($subject);
        $payRequestBuilder->setOutTradeNo($out_trade_no);
        $payRequestBuilder->setTotalAmount($total_amount);
        $payRequestBuilder->setTimeExpress($timeout_express);

        $payResponse = new \AlipayTradeService($config);
        $result=$payResponse->wapPay($payRequestBuilder,$config['return_url'],$config['notify_url']);

        return ; 
        }
    }
    //同步跳转
    public function return_url(){
       $config=config('alipay');
   require_once app_path('lib/alipay/wappay/service/AlipayTradeService.php');


        $arr=$_GET;
        $alipaySevice = new \AlipayTradeService($config); 
        $result = $alipaySevice->check($arr);
        /* 实际验证过程建议商户添加以下校验。
        1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
        2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
        3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
        4、验证app_id是否为该商户本身。
        */
        if($result) {//验证成功
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //请在这里加上商户的业务逻辑程序代码
            
            //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
            //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表

            //商户订单号

            $out_trade_no = htmlspecialchars($_GET['out_trade_no']);

            //支付宝交易号

            $trade_no = htmlspecialchars($_GET['trade_no']);
                
            echo "验证成功<br />外部订单号：".$out_trade_no;

            //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
            
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        }
        else {
            //验证失败
            echo "验证失败";
        }
    }
//异步跳转
    public function notify_url(){
    $config=config('alipay');
   require_once app_path('lib/alipay/wappay/service/AlipayTradeService.php');

            $arr=$_POST;
        $alipaySevice = new \AlipayTradeService($config); 
        $alipaySevice->writeLog(var_export($_POST,true));
        $result = $alipaySevice->check($arr);

        /* 实际验证过程建议商户添加以下校验。
        1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
        2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
        3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
        4、验证app_id是否为该商户本身。
        */
        if($result) {//验证成功
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //请在这里加上商户的业务逻辑程序代

            
            //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
            
            //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
            
            //商户订单号

            $out_trade_no = $_POST['out_trade_no'];

            //支付宝交易号

            $trade_no = $_POST['trade_no'];

            //交易状态
            $trade_status = $_POST['trade_status'];


            if($_POST['trade_status'] == 'TRADE_FINISHED') {

                //判断该笔订单是否在商户网站中已经做过处理
                    //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                    //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
                    //如果有做过处理，不执行商户的业务程序
                        
                //注意：
                //退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知
            }
            else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
                //判断该笔订单是否在商户网站中已经做过处理
                    //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                    //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
                    //如果有做过处理，不执行商户的业务程序            
                //注意：
                //付款完成后，支付宝系统发送该交易状态通知
            }
            //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
                
            echo "success";     //请不要修改或删除
                
        }else {
            //验证失败
            echo "fail";    //请不要修改或删除

        }

    }



}
