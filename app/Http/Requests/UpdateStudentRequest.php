<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
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
        $validation = [];
        $validation['fname'] = 'required|regex:/^([a-zA-ZéèêùûîâàäïëüÄËÏÜ ])+$/|min:2|max:30';
        $validation['lname'] = 'required|regex:/^([a-zA-ZéèêùûîâàäïëüÄËÏÜ ])+$/|min:2|max:20';
        if (request('email')) $validation['email'] = 'email';
        if (request('phone')) $validation['phone'] = 'regex:/^0( )?3( )?[234]( )?([0-9]( )?){7}$/';
        $validation['birth_date'] = 'required|date|before:now';
        if (request('address')) $validation['address'] = 'string|min:5|max:100';
        if (request('cin')) $validation['cin'] = 'regex:/^([0-9]{3}\.){3}[0-9]{3}$/';
        $validation['sex'] = ['required', 'regex:/man|woman/'];
        if (request('actual_job')) $validation['actual_job'] = 'string|min:2|max:100';
        if (request('photo')) $validation['photo'] = 'image|mimes:png,jpg,jpeg,jfif';
        if (request('machine_number')) $validation['machine_number'] = 'integer|min:1';
        $validation['family_situation'] = ['required', 'regex:/single|married/'];
        if (request('childer_number')) $validation['children_number'] = 'integer|min:1';
        if (request('study_level')) $validation['study_level'] = 'string|min:2|max:100';
        if (request('certified')) $validation['certified'] = 'boolean';
        return $validation;
    }
}
