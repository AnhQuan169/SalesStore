<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feeship extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'fee_city_id','fee_qh_id','fee_xa_id','fee_freeship'
    ];
    protected $primaryKey = 'fee_id';
    protected $table = 'tbl_feeship';

    public function city(){
        return $this->belongsTo('App\Models\City','fee_city_id');
    }

    public function province(){
        return $this->belongsTo('App\Models\Province','fee_qh_id');
    }
    
    public function wards(){
        return $this->belongsTo('App\Models\Wards','fee_xa_id');
    }
}
