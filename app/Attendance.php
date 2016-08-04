<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendance';
    protected $guarded = ['id'];
    protected $hidden = [];
    protected $dates = ['login_time', 'logout_time'];
    public $timestamps = false;
    protected $casts = [
        'id' => 'integer',
    ];

    public $validationRules = [
        'login_at' => 'required|date',
        'logout_at' => 'date',
    ];

    public function door()
    {
        return $this->belongsTo(Door::class);
    }

    public function advisor()
    {
        return $this->belongsTo(Advisor::class, 'advisor_id');
    }
}
