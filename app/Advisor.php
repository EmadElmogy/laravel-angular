<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advisor extends Model
{
    protected $table = 'advisors';
    protected $guarded = ['id'];
    protected $hidden = [];
    protected $dates = [];
    public $timestamps = false;
    protected $casts = [
        'id' => 'integer',
    ];

    public $validationRules = [
        'name' => 'required',
        'username' => 'required',
    ];

    public static $DAYS = [
        1 => 'Saturday',
        2 => 'Sunday',
        3 => 'Monday',
        4 => 'Tuesday',
        5 => 'Wednesday',
        6 => 'Thursday',
        7 => 'Friday',
    ];

    public static $TITLES = [
        1 => 'Make up',
        2 => 'Skin & Hair',
        3 => 'Shared',
    ];

    public function door()
    {
        return $this->belongsTo(Door::class);
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class, 'advisor_id');
    }

    public function getDayNameAttribute()
    {
        return static::$DAYS[$this->day_off];
    }

    public function getTitleNameAttribute()
    {
        return static::$TITLES[$this->title];
    }
}
