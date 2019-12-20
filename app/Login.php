<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
   public $primaryKey='a_id';
   public $table='admin';
   public $timestamps=false;
	//黑名单 表设计中允许为空的
   protected $guarded = [];	
    //白名单  表设计中不允许为空的
    protected $fillable=['a_name','pwd'];
}
