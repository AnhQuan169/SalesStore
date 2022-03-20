<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wards extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'xa_name','xa_type','qh_id'
    ];
    protected $primaryKey = 'xa_id';
    protected $table = 'tbl_xaphuongthitran';
}
