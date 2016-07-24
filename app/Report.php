<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'reports';
    protected $guarded = ['id'];
    protected $hidden = [];
    protected $dates = ['date'];
    public $timestamps = false;
    protected $casts = [
        'id' => 'integer',
    ];

    public $validationRules = [
        'advisor_id' => 'required',
        'door_id' => 'required',
    ];

    public function variations()
    {
        return $this->belongsToMany(Variation::class, 'report_products', 'report_id', 'variation_id')->withPivot('sales');
    }

    public function door()
    {
        return $this->belongsTo(Door::class, 'door_id');
    }

    public function advisor()
    {
        return $this->belongsTo(Advisor::class, 'advisor_id');
    }
}
