<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewJobRequest extends FormRequest
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
        return [
            'job_title'    => 'required',
            'job_description' => 'required',
            'job_location'    => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
          'job_title' => [ 'required' => 'The job needs to have a job title.' ],
          'job_description' => [ 'required' => 'The job needs to have a description.' ],
          'job_location' => [ 'required' => 'The job needs to have a location.' ],
        ];
    }
}
