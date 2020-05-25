<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class JobField extends Model
{
    use SoftDeletes;
    
    public $timestamps = false;

    public function setSlugAttribute($value) {
        // grab the title and slugify it
        $this->attributes['slug'] = Str::slug($this->name);
    }
    
    //post-job field relationship
    public function jobs() {
        return $this->hasMany('App\Job');
    }
}
