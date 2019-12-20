<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
     public $primaryKey='brand_id';
   public $table='brand';
   public $timestamps=false;
	//黑名单 表设计中允许为空的
   protected $guarded = [];	
    //白名单  表设计中不允许为空的
    protected $fillable=['brand_name','brand_url'];
}
