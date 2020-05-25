<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Carbon\Carbon;
use Auth;
use Storage;

class JobCollection extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'company' => $this->company->name,
            'title' => $this->job_title,
            'slug' => $this->slug,
            'location' => $this->job_location,
            'date_posted' => $this->updated_at->diffForHumans(),
            'salary' => $this->salary,
            'type' => $this->job_type->name,
            'field' => $this->job_field->name,
            'logo' => env('APP_URL').($this->company->logo),
            $this->mergeWhen(Auth::user() && Auth::user()->permission >= config('constants.ADMIN'), [
                'status' => $this->status,
                'verified_by' => $this->verified_by,
                'date_created' => $this->created_at->isoFormat('LLL'),
                'date_verified' => $this->updated_at->isoFormat('LLL'),
            ]),
        ];
    }
}
