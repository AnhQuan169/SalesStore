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
}
