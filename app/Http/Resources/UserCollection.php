<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Auth;

class UserCollection extends Resource
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
            'name' => $this->first_name . ' ' . $this->last_name,
            'email' => $this->email,
            'id' => $this->id,
            'permission' => $this->permission,
            'role' => ($this->permission === config('constants.EMPLOYER')) ? 'Employer' : (($this->permission === config('constants.ADMIN')) ? 'Admin' : (($this->permission === config('constants.SUPER-ADMIN')) ? 'Super Admin' : 'User')),
        ];
    }
}
