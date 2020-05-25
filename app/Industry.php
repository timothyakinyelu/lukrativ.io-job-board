<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Industry extends Model
{
    use SoftDeletes;
    
    public $timestamps = false;
    
    public function companies() {
        return $this->hasMany('App\Company');
    }

    public function jobs() {
        return $this->hasManyThrough('App\Job', 'App\Company');
    }
}
