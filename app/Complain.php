<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Complain extends Model
{
    protected $table = 'complains';
    protected $guarded = ['id'];
    protected $hidden = [];
    protected $dates = [];
    public $timestamps = false;
    protected $casts = [
        'id' => 'integer',
    ];

    public $validationRules = [
        'comment' => 'required',
    ];

    public function advisor()
    {
        return $this->belongsTo(Advisor::class, 'advisor_id');
    }

    public function door()
    {
        return $this->belongsTo(Door::class, 'door_id');
    }
}
