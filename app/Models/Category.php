<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_en',
        'name_ar',
        'image',
    ];
    public function getImageAttribute($value)
    {

        return asset('uploads/categories/' . $value);
    }
    public function getImageNameAttribute()
    {
       return md5(uniqid());


    }
    public function scopeSelection($query)
    {
        return $query->select('id','image', 'name_' . app()->getLocale() . ' as name');
    }

}
