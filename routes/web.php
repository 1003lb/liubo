<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::get('/', function () {
//     return view('welcome');
// });

//get路由
//Route::get('login','Index\IndexController@login');//login
//post请求													路由重命名
//Route::post('dologin','Index\IndexController@dologin')->name('dolog');//login

//必选参数
// Route::get('user/{id}',function($id){
// 	return 'User'.$id;
// });

//可选参数
// Route::get('user/{name?}',function($name='王玉杰'){
// 	return $name;
// });

//路由限制
//name
// Route::get('user/{name}', function ($name) {
//  return  $name ;//必须是字母且不能为空 返回所写字母
// })->where('name', '[A-Za-z]+');

//id
// Route::get('user/{id}',function ($id){
// 	return $id;//ID必须是数字 返回所写数字
// })->where('id','[0-9]+');

//同时指定 id 和 name 的数据格式
//Route::get('goods/{id}/{name}','Index\IndexController@goods')->where(['id'=>'\d+','name'=>'\w+']);



Route::view('/log','log');//登录页面
Route::post('/dologin','Admin\LoginController@dologin');//登录
//品牌
Route::prefix('/brand')->middleware('CheckLogin')->group(function(){
Route::get('index','Admin\BrandController@index');//列表
Route::get('create','Admin\BrandController@create');//添加展示
Route::post('store','Admin\BrandController@store');//添加展示
//Route::get('delete/{id}','Admin\BrandController@destroy');//删除
Route::any('delete','Admin\BrandController@delete');//ajax删除
Route::get('edit/{id}','Admin\BrandController@edit');//修改页面
Route::post('update/{id}','Admin\BrandController@update');//修改

});

//管理员
Route::prefix('/admin')->middleware('CheckLogin')->group(function(){
	Route::any('index','Admin\AdminController@index');//列表
	Route::any('create','Admin\AdminController@create');//添加页面
	Route::any('store','Admin\AdminController@store');//添加
	Route::any('delete/{id}','Admin\AdminController@destroy');//删除
	Route::any('edit/{id}','Admin\AdminController@edit');//修改页面
	Route::any('update/{id}','Admin\AdminController@update');//修改

});
//分类
Route::prefix('/cate')->middleware('CheckLogin')->group(function(){
	Route::any('index','Admin\CateController@index');//列表
	Route::any('create','Admin\CateController@create');
	Route::any('store','Admin\CateController@store');
	Route::any('delete/{id}','Admin\CateController@destroy');
	Route::any('edit/{id}','Admin\CateController@edit');
	Route::any('update/{id}','Admin\CateController@update');
});
//商品
Route::prefix('/goods')->middleware('CheckLogin')->group(function(){
	Route::any('index','Admin\GoodsController@index');//列表
	Route::any('create','Admin\GoodsController@create');
	Route::any('store','Admin\GoodsController@store');
	Route::any('delete/{id}','Admin\GoodsController@destroy');
	Route::any('edit/{id}','Admin\GoodsController@edit');
	Route::any('update/{id}','Admin\GoodsController@update');
});

Route::prefix('/article')->middleware('CheckLogin')->group(function(){
	Route::any('index','Admin\ArticleController@index');
	Route::any('create','Admin\ArticleController@create');
	Route::any('store','Admin\ArticleController@store');
	Route::any('delete','Admin\ArticleController@delete');//ajax删除	
	//Route::any('delete/{id}','Admin\ArticleController@destroy');//普通删除
	Route::any('edit/{id}','Admin\ArticleController@edit');
	Route::any('update/{id}','Admin\ArticleController@update');
	Route::any('checkonly','Admin\ArticleController@checkonly');//ajax唯一性验证	
});
//设置cookie
// Route::get('addcookie',function(){
// 	 $res=response('公主殿下,微臣来迟了')->cookie('aa','老子不跪',4);
// 	 dump($res);
// 	 $aa=request()->cookie('aa');
// 	 dd($aa);
// });

// Route::get('addcookie',function(){
// 	\Cookie::queue('yoyo', 'jjj', 2);

// 	//return response('公主殿下,微臣来迟了')->cookie('aa','老子不跪',4);
// });
//获取cookie
// Route::get('getcookie',function(){
// 	//设置cookie
// 	//\Cookie::queue(\Cookie::make('uu', '0215', 2));
// 	\Cookie::queue('yoyo', 'jjj', 2);

// 	//获取的两种方式
// 	//echo request()->cookie('yoyo');
// 	echo \Cookie::get('yoyo');
// });

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');



//注册
Route::get('/reg', 'Index\LoginController@reg');
Route::any('/doreg', 'Index\LoginController@doreg');

//登录
Route::get('/login', 'Index\LoginController@login');
Route::any('/logindo', 'Index\LoginController@logindo');

//前台
Route::any('/index', 'Index\IndexController@index')->middleware('IndexLogin');//前台首页

Route::any('/proinfo/{id}', 'Index\IndexController@proinfo')->middleware('IndexLogin');//商品展示页面
Route::any('/prolist/{id}', 'Index\IndexController@prolist')->middleware('IndexLogin');//分类商品展示页面
Route::any('/car', 'Index\IndexController@car')->middleware('IndexLogin');//添加购物车展示页面
Route::any('/cartList', 'Index\IndexController@cartList')->middleware('IndexLogin');//购物车展示页面
Route::any('/carAdd', 'Index\IndexController@carAdd')->middleware('IndexLogin');//购物车添加
Route::post('/getCount', 'Index\IndexController@getCount');//获去总价
Route::post('/changeNum', 'Index\IndexController@changeNum');//更改购买数量
Route::post('/getTotal', 'Index\IndexController@getTotal');  //获取小计
Route::post('/del', 'Index\IndexController@del');//删除购物车数据
Route::get('/pay', 'Index\IndexController@pay');//去结算

Route::any('/pays/{order_id}', 'Index\IndexController@pays');//去支付
Route::any('/return_url', 'Index\IndexController@return_url');//同步跳转
Route::any('/notify_url', 'Index\IndexController@notify_url');//异步跳转



Route::get('/submitOrder', 'Index\IndexController@submitOrder');
Route::get('/success', 'Index\IndexController@success');
Route::any('/address', 'Index\IndexController@address')->middleware('IndexLogin');//地址

Route::get('/payDo/{order_id}', 'Index\IndexController@payDo');


Route::any('/user', 'Index\IndexController@user')->middleware('IndexLogin');//用户详情

//邮件
Route::get('/send_email','MailController@send_email');
