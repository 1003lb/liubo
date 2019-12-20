<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Article;
use App\Cate;
class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $pageSize = config('app.pageSize');
        $a_name = request()->a_name;
        $cate_id=request()->cate_id;

        $where=[];
        if ($a_name) {
            $where[]=['a_name','like',"%$a_name%"];
        }
       
        if ($cate_id) {
         $where[]=['category.cate_id','=',$cate_id];
        }
          $CateInfo = Cate::get();
        $data=Article::join("category","article.cate_id","=","category.cate_id")
        ->orderBy('a_id','desc')
        ->select('article.*','cate_name')
        ->where($where)
        ->paginate($pageSize);

//dd($data);
        $query=request()->all();
      return view('admin.article.index',['data'=>$data,'query'=>$query,'CateInfo'=>$CateInfo]);  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $CateInfo = Cate::get();
      return view('admin.article.create',['CateInfo'=>$CateInfo]);  
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
      // dd($post);
 $request->validate([
    'a_name' => 'required|unique:article|max:17|min:2',
    'name' => 'required',

 ],[
    'a_name.required'=>'名称必填',
    'a_name.unique'=>'名称已存在',
    'a_name.max'=>'名称最大17位',
    'a_name.min'=>'名称最小2位',
    'name.required'=>'作者必填',
]);
    $res=Article::insert($post);
   // dd($res);
    if($res){
        return redirect('/article/index')->with('msg','提交成功');
        }
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
         if(!$id){
        echo 404;
       }
       $article=Article::find($id);
       //dd($article);
    $cate=Cate::get();
    return view('admin.article.edit',['article'=>$article,'cate'=>$cate]);

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
       if(!$id){
        echo 404;
       }
       $data=$request->except('_token');
       //dd($data);
    $res=Article::where('a_id',$id)->update($data);
        if($res){
          echo "<script>alert('修改成功');location.href='/article/index'</script>";
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
     if(request()->isAjax()){
        $a_id=input('a_id');
        $res=Article::delete($a_id);
        if($res){
            echo json_encode(['code'=>'00000','msg'=>'删除成功']);
        }
     }
  }
//ajax删除
  public function delete(){
    $id=request()->a_id;
    if($id){
        $res=Article::destroy($id);
        if($res){
            echo json_encode(['code'=>'00000','msg'=>"删除成功"]);
        }else{
            echo 2;
        }
    }else{
        echo 2;
    }
  }
  //ajax唯一性验证
  public  function checkonly(){
    $a_name=request()->a_name;
//echo $article;
   $where=[];
   if($a_name){
    $where['a_name']=$a_name;
   }
   $count=Article::where($where)->count();
   echo $count;
  }
}
