<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Variation extends Model
{
    protected $table = 'variations';
    protected $guarded = ['id'];
    protected $hidden = [];
    protected $dates = [];
    public $timestamps = false;
    protected $casts = [
        'id' => 'integer',
    ];

    public $validationRules = [
        'name' => 'required',
        'product_id' => 'required',
        'barcode' => 'required',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
