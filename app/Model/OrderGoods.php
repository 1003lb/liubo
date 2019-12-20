<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderGoods extends Model
{
    public $primaryKey='id';

    protected $table='order_goods';

    public $timestamps=false;

    protected $guarded=[];
}
