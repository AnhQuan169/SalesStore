<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_details extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'order_code','product_id','order_detail_name','order_detail_quantity','order_coupon','order_fee'
    ];
    protected $primaryKey = 'order_detail_id';
    protected $table = 'tbl_order_details';

    // public function customer(){
    //     return $this->belongsTo('App\Models\City','fee_city_id');
    // }

    // public function province(){
    //     return $this->belongsTo('App\Models\Province','fee_qh_id');
    // }
}
