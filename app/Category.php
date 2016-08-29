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
        'brand' => 'required:in:1,2',
    ];

    public static $BRANDS = [
        1 => 'L\'Oreal Paris',
        2 => 'Maybelline',
    ];

    public static $BRANDIMAGES = [
        1 => 'http://4.bp.blogspot.com/-eoWkCLylN00/VVi6XJ0b9NI/AAAAAAAACc4/Vd64-uu1S1U/s1600/Loreal-paris-logo-vector.png',
        2 => 'https://stuffled.com/vector/wp-content/uploads/sites/5/2014/07/Maybelline_Logo-vector-image.png',
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
