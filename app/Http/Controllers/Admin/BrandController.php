<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Brand;
//use Illuminate\Support\Facades\Cache;//memcacheh缓存
use Illuminate\Support\Facades\Redis;//redis
class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {   
        //全局辅助函数
        //session(['name'=>'延安']);//设置
       // request()->session()->save();//存储到服务端
        // session(['name'=>null]);//删除
        // request()->session()->save();//存储到服务端
         //$name=session('name');//获取
        //dd($name);
    //request实例
//    request()->session()->put('age', '18');//设置
//    request()->session()->save();
// $age=request()->session()->get('age');//获取
// dump($age);

// $age= request()->session()->pull('age');//先获取再删除
// dump($age);


// request()->session()->forget('key');//删除单个session
// $age=request()->session()->get('age');//获取
// dd($age);

//$request->session()->flush();//清空所有session

        $brand_name=request()->brand_name;
        $brand_url=request()->brand_url;
        //dd($brand_name);
        $where=[];
            if($brand_name){
                $where[]=['brand_name','like',"%$brand_name%"];
            }
            if($brand_url){
                $where[]=['brand_url','like',"%$brand_url%"];
            }
            //Cache::flush();//清空缓存
        $page=request()->page;
       // $data=Cache::get('data_'.$page.'_'.$brand_name.'_'.$brand_url);//取数据 //memcacheh
       // echo 'data_'.$page.'_'.$brand_name.'_'.$brand_url; //memcacheh
    
    //Redis::del('data_'.$page.'_'.$brand_name.'_'.$brand_url);
      $data=Redis::get('data_'.$page.'_'.$brand_name.'_'.$brand_url);
      $data=unserialize($data);
     //dump($data);die;
        if(!$data){

         echo "走DB";

          $pageSize=config('app.pageSize');
        // 监听SQL
       // DB::connection()->enableQueryLog();
        $data=Brand::where($where)->orderBy('brand_id','desc')->paginate($pageSize);
//Cache::put(['data_'.$page.'_'.$brand_name.'_'.$brand_url=>$data],30);//memcache存数据 限时30秒 //memcacheh
    //dd($data);     
     Redis::setex('data_'.$page.'_'.$brand_name.'_'.$brand_url,20,serialize($data));
     }
        // 监听SQL语句
         //$logs = DB::getQueryLog();
        //dump($logs);
        $query=request()->all();
       return view('admin.brand.index',['data'=>$data,'query'=>$query]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //复制粘贴  改一下
    $request->validate([
 'brand_name' => 'required|unique:brand|max:17|min:2',
 'brand_url' => 'required',
 ],[
    'brand_name.required'=>'品牌名称必填',
    'brand_name.unique'=>'品牌名称已存在',
    'brand_name.max'=>'品牌名称最大17位',
    'brand_name.min'=>'品牌名称最小2位',
    'brand_url.required'=>'品牌路径必填',
 ]);
       $post=$request->except('_token');
       //dd($post);
        
      
       //文件上传
    if($request->hasFile('brand_logo')){
      $post['brand_logo']=$this->upload('brand_logo');
   }
   

        // $brand=Brand::create($post);
       // dd($post);
        //$query=request()->all();
        $brand=new Brand;
        $brand->brand_name=$post['brand_name'];
        $brand->brand_url=$post['brand_url'];
        $brand->brand_logo=$post['brand_logo']??'';
        $brand->brand_desc=$post['brand_desc'];
        $brand=$brand->save(); 

        if($brand){
        return redirect('/brand/index')->with('ms','添加成功');
       }
    }

  public  function upload($img_name){
    if (request()->file($img_name)->isValid()) {
         $photo = request()->file($img_name);
        $store_result = $photo->store('uploads');
         return $store_result;
    }
 exit('未获取到上传文件或上传过程出错');

    } 

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!$id){
             abort(404);
        }
        $data=Brand::where('brand_id',$id)->first();
        //dd($data);
    return view('admin.brand.edit',['data'=>$data]);
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
 $request->validate([
 'brand_name' => 'required|unique:brand|max:17|min:2',
 'brand_url' => 'required',
 ],[
    'brand_name.required'=>'品牌名称必填',
    'brand_name.unique'=>'品牌名称已存在',
    'brand_name.max'=>'品牌名称最大17位',
    'brand_name.min'=>'品牌名称最小2位',
    'brand_url.required'=>'品牌路径必填',
 ]);
       $post=$request->except('_token');
       //dd($post);
        if($request->hasFile('brand_logo')){
      $post['brand_logo']=$this->upload('brand_logo');
   }
   //dd($post);
        // $brand=new Brand;
        // $brand->brand_name=$post['brand_name'];
        // $brand->brand_url=$post['brand_url'];
        // $brand->brand_logo=$post['brand_logo']??'';
        // $brand->brand_desc=$post['brand_desc'];
        // $brand=$brand->save(); 
        $res=Brand::where('brand_id',$id)->update($post);
        //dd($res);
    if($res){
        return redirect('/brand/index')->with('msg','修改成功');
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
            abort(404);
      }
    $res=Brand::where('brand_id',$id)->delete();
       //dd($res);
    if($res){
        echo "<script>alert('删除成功');location.href='/brand/index';</script>";
        //return redirect('/brand')->with('sq','删除成功');
       }
    }
    public function delete(){
        $id=request()->brand_id;
        if($id){
            $res=Brand::destroy($id);
          //dd($res);
      if($res){
        echo 1;
        //echo json_encode(['code'=>'00000','msg'=>"删除成功"]);
      }else{
            echo 2;
      }
        }else{
             echo 2;
        } 
    }







}
