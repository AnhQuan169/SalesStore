<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'customer_id','shipping_id','order_total','order_status','order_code'
    ];
    protected $primaryKey = 'order_id';
    protected $table = 'tbl_order';

    // public function customer(){
    //     return $this->belongsTo('App\Models\City','fee_city_id');
    // }

    // public function province(){
    //     return $this->belongsTo('App\Models\Province','fee_qh_id');
    // }
}
