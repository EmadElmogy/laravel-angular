<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    protected $table = 'apartments';
    protected $guarded = ['id'];
    protected $hidden = [];
    protected $dates = [];
    public $timestamps = false;
    protected $casts = [
        'id' => 'integer',
    ];

    public $validationRules = [
        'move_in_date' => 'required',
        'street'=>'required'
    ];



    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }



}
