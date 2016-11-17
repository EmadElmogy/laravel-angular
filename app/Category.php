<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $guarded = ['id'];
    protected $hidden = [];
    protected $dates = [];
    public $timestamps = false;
    protected $casts = [
        'id' => 'integer',
    ];

    public $validationRules = [
        'name' => 'required',
        //'brand' => 'required:in:1,2',
    ];

    public static $BRANDS = [
        1 => 'L\'Oreal Paris',
        2 => 'Maybelline',
        3 => 'HairCare'
    ];

    public static $BRANDIMAGES = [
        1 => 'http://104.131.10.200/uploads/loreal_paris2.png',
        2 => 'http://104.131.10.200/uploads/maybe.png',
        3=> 'http://104.131.10.200/uploads/hair_care.png',
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function getBrandNameAttribute()
    {
        return static::$BRANDS[$this->brand];
    }
}
