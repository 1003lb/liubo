<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $primaryKey='user_id';
   public $table='user';
   public $timestamps=false;
	//黑名单 表设计中允许为空的
   protected $guarded = [];	
    //白名单  表设计中不允许为空的
    protected $fillable=['email','pwd','tel'];
}
