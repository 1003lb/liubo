<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
   public $primaryKey='goods_id';
   public $table='goods';
   public $timestamps=false;
	//黑名单 表设计中允许为空的
   protected $guarded = [];	
    //白名单  表设计中不允许为空的
    protected $fillable=['goods_name','goods_price','goods_num'];
}
