<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
   public $primaryKey='order_id';

    protected $table='order';

    public $timestamps=false;

    protected $guarded=[];
}
