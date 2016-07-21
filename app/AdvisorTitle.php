<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdvisorTitle extends Model
{
    protected $table = 'advisors_titles';
    protected $guarded = ['id'];
    protected $hidden = [];
    protected $dates = [];
    public $timestamps = false;
    protected $casts = [
        'id' => 'integer',
    ];

    public $validationRules = [
        'name' => 'required',
    ];

    public function advisors()
    {
        return $this->belongsToMany(AdvisorTitle::class, 'advisor_titles', 'title_id', 'advisor_id');
    }
}
