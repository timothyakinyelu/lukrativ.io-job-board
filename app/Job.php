<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Job extends Model
{
    use SoftDeletes;
    
    protected $guarded = [
        'id',
    ];

    public function setSlugAttribute($value) {
        // grab the title and slugify it
        $this->attributes['slug'] = Str::slug($this->job_title);
    }

    //A post belongs to a job type
    public function job_type() {
        return $this->belongsTo('App\JobType');
    }

    //A post belongs to a user
    public function user() {
        return $this->belongsTo('App\User');
    }

    //A post belongs to a job field
    public function job_field() {
        return $this->belongsTo('App\JobField');
    }

    //A post belongs to a company
    public function company() {
        return $this->belongsTo('App\Company');
    }
}
