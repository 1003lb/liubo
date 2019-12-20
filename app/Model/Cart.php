<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{ 
	    public $primaryKey='cart_id';
   public $table='cart';
   public $timestamps=false;
	//黑名单 表设计中允许为空的
   protected $guarded = [];	
    //白名单  表设计中不允许为空的
    protected $fillable=['cart_name'];
}
