<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable=['title','slug','photo','is_parent','summary','status','parent_id'];

    //Shifting Child To Parent
    public static function shiftChild($cat_id){
        return Category::whereIn('id',$cat_id)->update(['is_parent'=>1]);

    }

    //Get Child ID By Parent ID
    public static function getChildByParentID($id){
        return Category::where('parent_id',$id)->pluck('title','id');
    }

    //Relationship between Category and Products
    public function products(){

        return $this->hasMany('App\Models\Product','cat_id','id');
    }
}
