<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cate extends Model
{
     public $primaryKey='cate_id';
   public $table='category';
   public $timestamps=false;
	//黑名单 表设计中允许为空的
   protected $guarded = [];	
    //白名单  表设计中不允许为空的
    protected $fillable=['cate_name'];
}
