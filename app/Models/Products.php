<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'name','category_id','brand_id','desc','content','price','image','status'
    ];
    protected $primaryKey = 'id';
    protected $table = 'tbl_product';

    public function category(){
        return $this->belongsTo('App\Models\Category','category_id');
    }

    public function brand(){
        return $this->belongsTo('App\Models\Brand','brand_id');
    }
}
