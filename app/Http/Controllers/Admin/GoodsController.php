<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Goods;
use App\Cate;
use App\Brand;
class GoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //调用函数
        // showMsg();
        // hh();
        $pageSize = config('app.pageSize');
          $goods_name = request()->goods_name;
        $where=[];
        if ($goods_name) {
            $where[]=['goods_name','like',"%$goods_name%"];
        }

         $data=Goods::join("brand","goods.brand_id","=","brand.brand_id")
         ->orderBy('goods_id','desc')
            ->join("category","goods.cate_id","=","category.cate_id")
            ->select('goods.*','brand_name','cate_name')
            ->where($where)
            ->paginate($pageSize);
            foreach($data as $k=>$v){
                $data[$k]->goods_imgs = explode('|',$v->goods_imgs);
            }
          $query = request()->all();
      

       return view('admin.goods.index',['data'=>$data,'query'=>$query]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $BInfo = Brand::get();
        $CateInfo = Cate::get();
         $info = $this->get_cate($CateInfo);
       return view('admin.goods.create',['info'=>$info,'BInfo'=>$BInfo]);
    }

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
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post=$request->except('_token');
      // dupm($post);
          $request->validate([
    'goods_name' => 'required|unique:goods|max:17|min:2',
    'goods_price' => 'required',
    'goods_num' => 'required',

 ],[
    'goods_name.required'=>'商品名称必填',
    'goods_name.unique'=>'商品名称已存在',
    'goods_name.max'=>'商品名称最大17位',
    'goods_name.min'=>'商品名称最小2位',
    'goods_price.required'=>'商品价格必填',
    'goods_num.required'=>'商品数量必填',

    
 ]);
       //单文件上传
     if($request->hasFile('goods_img')){
     $post['goods_img']=$this->upload('goods_img');
   }
    //多文件上传
    
     if($request->hasFile('goods_imgs')){
           
        $imgs=$this->upload('goods_imgs');
         $post['goods_imgs']=implode('|',$imgs);
      
   }
        //dd($post);
         $goods=new Goods;
        $goods->goods_name=$post['goods_name'];
        $goods->goods_img=$post['goods_img']??'';
        $goods->goods_imgs=$post['goods_imgs']??'';
        $goods->goods_num=$post['goods_num'];
        $goods->goods_price=$post['goods_price'];
        $goods->cate_id=$post['cate_id'];
        $goods->brand_id=$post['brand_id'];
        $goods=$goods->save(); 
     if($goods){
        return redirect('/goods/index')->with('msg','添加成功');
        }
    }
//单文件上传
 public  function upload($goods_img){  
    $imgs=request()->file($goods_img);
if(is_array($imgs)){
    //多文件上传
    $result=[];
    foreach ($imgs as $v) {
             if ($v->isValid()){
           $result[]=$v->store('goods_img'); 
             }
        }
        return $result;
}else{
    //单文件上传
    if ($imgs->isValid()){
   $store_result =request()->file($goods_img)->store('goods_img');
         return $store_result;
     }
    }
    
 exit('文件上传过程出错');

 } 
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         if (!$id) {
            echo 404;
        }
       
        $goodsInfo=goods::find($id);
        $BInfo=Brand::all();
        $Cate_Info = Cate::get();
        $info = $this->get_cate($Cate_Info);
        return view('admin.goods.edit',['BInfo'=>$BInfo,'info'=>$info,'goodsInfo'=>$goodsInfo]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data=$request->except('_token');
          if($request->hasFile('goods_img')){
            $post['goods_img']=$this->upload('goods_img');
        }
        $res=goods::where('goods_id',$id)->update($data);
        if($res){
            return redirect('goods/index')->with('sq','修改成功');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!$id){
            echo 404;
        }
        $res=Goods::where('goods_id',$id)->delete();
        //dd($res);
        if($res){
            echo "<script>alert('删除成功');location.href='/goods/index'</script>";
        }
    }


}
