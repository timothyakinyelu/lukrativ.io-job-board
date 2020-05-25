<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];
    
    //A company-user relationship
    public function user() {
        return $this->belongsTo('App\User');
    }

    //A company-job relationship
    public function jobs() {
        return $this->hasMany('App\Job');
    }

    //A company-industry relationship
    public function industry() {
        return $this->belongsTo('App\Industry');
    }
}
