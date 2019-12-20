<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Login;
use DB;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
            $post=request()->except('_token');
//dd($post);
    $user=Login::where($post)->first();
    if($user){
        session(['user'=>$user]);
        request()->session()->save();
        return redirect('/brand/index');
    }
    }
}
