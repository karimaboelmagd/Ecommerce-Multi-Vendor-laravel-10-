<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable=['title','slug','summary','description','stock','brand_id','cat_id','child_cat_id','vendor_id','photo','price','offer_price','discount','size','condition','status'];


    public function brand(){
        return $this->belongsTo('App\Models\Brand');
    }

    public function related_products(){
        return $this->hasMany('App\Models\Product','cat_id','cat_id')->where('status','active')->limit(10);
    }

}
