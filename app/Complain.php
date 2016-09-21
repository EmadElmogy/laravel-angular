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
        'type' => 'in:1,2,3,4,5',
    ];

    public static $TYPES = [
        1 => 'Consumer',
        2 => 'Product',
        3 => 'Maintenance',
        4 => 'Competition',
        5 => 'Others',
    ];

    public function advisor()
    {
        return $this->belongsTo(Advisor::class, 'advisor_id');
    }

    public function door()
    {
        return $this->belongsTo(Door::class, 'door_id');
    }

    public function getTypeNameAttribute()
    {
        return static::$TYPES[$this->type];
    }
}
