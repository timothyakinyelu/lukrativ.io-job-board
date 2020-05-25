<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //password inputed now but will be generated automatically
        // later and changed with a password reset email
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'avatar' => 'file|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
