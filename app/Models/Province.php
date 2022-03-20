<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'qh_name','qh_type','city_id'
    ];
    protected $primaryKey = 'qh_id';
    protected $table = 'tbl_quanhuyen';
}
