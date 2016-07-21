<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wiki extends Model
{
    protected $table = 'wikis';
    protected $guarded = ['id'];
    protected $hidden = [];
    protected $dates = [];
    public $timestamps = false;
    protected $casts = [
        'id' => 'integer',
    ];

    public $validationRules = [
        'title' => 'required',
        'link' => 'required',
        'type' => 'required:in:1,2',
    ];

    public static $TYPES = [
        1 => 'Youtube Video',
        2 => 'PDF File',
    ];

    public function getTypeNameAttribute()
    {
        return static::$TYPES[$this->type];
    }
}
