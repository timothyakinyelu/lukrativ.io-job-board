<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Auth;
use Storage;

class UserResource extends JsonResource
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
            'name' => $this->first_name . ' ' . $this->last_name,
            'email' => $this->email,
            'avatar' => Storage::url($this->avatar),
            $this->mergeWhen(Auth::user() && Auth::user()->permission >= config('constants.ADMIN'), [
                'id' => $this->id,
                'permission' => $this->permission,
                'role' => ($this->permission == config('constants.EMPLOYER')) ? 'Employer' : (($this->permission == config('constants.ADMIN')) ? 'Admin' : (($this->permission == config('constants.SUPER-ADMIN')) ? 'Super Admin' : 'User')),
                'notifications' => $this->notifications,
            ]), 
        ];
    }
}
