<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Door extends Model
{
    protected $table = 'doors';
    protected $guarded = ['id'];
    protected $hidden = [];
    protected $dates = [];
    public $timestamps = false;
    protected $casts = [
        'id' => 'integer',
    ];

    public $validationRules = [
        'name' => 'required',
        'site_id' => 'required',
        'door_lng' => 'regex:/^[-]?\d*(\.\d+)$/',
        'door_lat' => 'regex:/^[-]?\d*(\.\d+)$/'
    ];

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id');
    }

    public function advisors()
    {
        return $this->hasMany(Advisor::class, 'door_id');
    }

    public function complains()
    {
        return $this->hasMany(Complain::class, 'door_id');
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'door_id');
    }
}
