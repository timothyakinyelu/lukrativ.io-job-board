<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Auth;

class JobResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'company' => $this->company->name,
            'title' => $this->job_title,
            'description' => $this->job_description,
            'location' => $this->job_location,
            'about' => $this->company->about,
            'address'=> $this->company->address,
            'salary' => $this->salary,
            'type' => $this->job_type->name,
            'field' => $this->job_field->slug,
            'link' => $this->application_link,
            'email' => $this->application_email,
            'facebook' => $this->company->facebook_url,
            'linkedin' => $this->company->linkedin_url,
            'twitter' => $this->company->twitter_url,
            'deadline' => $this->closing_date,
            $this->mergeWhen(Auth::user() && Auth::user()->permission >= config('constants.ADMIN'), [
                'id' => $this->id,
                'status' => $this->status,
            ]),
        ];
    }
}
