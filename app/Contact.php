<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contacts';
    protected $guarded = ['id'];
    protected $hidden = [];
    protected $dates = ['date'];
    public $timestamps = false;
    protected $casts = [
        'id' => 'integer',
    ];

    public $validationRules = [
        'name' => 'required',
        'email' => 'required',
    ];

    public function apartments()
    {
        return $this->hasMany(Apartment::class, 'contact_id');
    }
}
