<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';
    protected $guarded = ['id'];
    protected $hidden = [];
    protected $dates = ['date'];
    public $timestamps = false;
    protected $casts = [
        'id' => 'integer',
    ];

    public $validationRules = [
        'name' => 'required',
        'mobile' => 'required',
    ];

    public function reports()
    {
        return $this->hasMany(Report::class, 'customer_id');
    }
}
