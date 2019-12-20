<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Admin;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {    $a_name=request()->a_name;
        $where=[];
        if($a_name){
        $where[]=['a_name','like',"%$a_name%"];
    }
        $data=Admin::where($where)->orderBy('a_id','desc')->paginate(3);
         $query=request()->all();
         return view('admin.admin.index',['data'=>$data,'query'=>$query]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.admin.create');
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
        //dd($post);admin
        $request->validate([
 'admin_name' => 'required|unique:brand|max:17|min:2',
 'pwd' => 'required',
 ],[
    'admin_name.required'=>'管理员昵称必填',
    'admin_name.unique'=>'管理员已存在',
    'admin_name.max'=>'管理员昵称最大17位',
    'admin_name.min'=>'管理员昵称最小2位',
    'pwd.required'=>'验证密码必填',
 ]);
       //文件上传
       if($request->hasFile('a_img')){
     $post['a_img']=$this->upload('a_img');
   }
//dd($img);
        $admin=new Admin;
        $admin->a_name=$post['a_name'];
        $admin->a_img=$post['a_img']??'';
        $admin->a_age=$post['a_age'];
        $admin->a_sex=$post['a_sex'];
        $admin->email=$post['email'];
        $admin->pwd=$post['pwd'];
        $admin=$admin->save(); 
       //dd($res);
    if($admin){
        return redirect('/admin/index')->with('msg','添加成功');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public  function upload($a_img){
    if (request()->file($a_img)->isValid()){
         $photo = request()->file($a_img);
        $store_result = $photo->store('admin_img');
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
            echo 404;
        }
        $data=Admin::where('a_id',$id)->first();
        return view('admin.admin.edit',['data'=>$data]);
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
  if($request->hasFile('a_img')){
     $post['a_img']=$this->upload('a_img');
   }
        //  $admin=new Admin;
        // $admin->a_name=$post['a_name'];
        // $admin->a_img=$post['a_img']??'';
        // $admin->a_age=$post['a_age'];
        // $admin->a_sex=$post['a_sex'];
        // $admin->email=$post['email'];
        // $admin->pwd=$post['pwd'];
        // $admin=$admin->save(); 
        $post=$request->except('_token');
       // dd($post);
   $res=Admin::where('a_id',$id)->update($post);
   //dd($res);
    if($res){
        return redirect('/admin/index')->with('sq','修改成功');
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
        $res=Admin::where('a_id',$id)->delete();
        //dd($res);
    if($res){
        echo "<script>alert('删除成功');location.href='/admin/index';</script>";
        }
    }
}
