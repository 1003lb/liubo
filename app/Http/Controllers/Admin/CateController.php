<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Cate;
class CateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         //$pageSize = config('app.pageSize');
        $cate_name = request()->cate_name;
        $where=[];
        if ($cate_name) {
            $where[]=['cate_name','like',"%$cate_name%"];
        }

        $data = Cate::where($where)->orderBy('cate_id','desc')->paginate(10);
        $query = request()->all();
       return view('admin.cate.index',['data'=>$data,'query'=>$query]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Cate::get();
        $cateInfo = $this->get_cate($data);
        return view('admin.cate.create',['cateInfo'=>$cateInfo]);
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
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      
      $post=$request->except('_token');
      //dd($post);
      
      $cate=Cate::create($post);
      if($cate){
        return redirect('/cate/index')->with('msg','提交成功');
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
        if (!$id) {
            echo 404;
        }
       
        $date=Cate::find($id); 
        //dd($date);
        $data = Cate::get();
         $cateInfo = $this->get_cate($data);
        return view('admin.cate.edit',['date'=>$date,'cateInfo'=>$cateInfo]);
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
      $post=$request->except('_token');
        $res=Cate::where('cate_id',$id)->update($post);
       if($res){
            echo "<script>alert('修改成功');location.href='/cate/index';</script>";
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
        $res=Cate::where('cate_id',$id)->delete();
        //dd($res);
    if($res){
            echo "<script>alert('删除成功');location.href='/cate/index';</script>";
        }
    }

  
}
