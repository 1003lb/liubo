<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Login;
use DB;
class LoginController extends Controller
{
  public function dologin(){
  	$post=request()->except('_token');
//dd($post);
  	$user=Login::where($post)->first();
  	if($user){
  		session(['user'=>$user]);
  		request()->session()->save();
  		return redirect('/article/index');
  	}
  }
}
