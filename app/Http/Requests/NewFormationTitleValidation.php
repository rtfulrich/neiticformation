<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewFormationTitleValidation extends FormRequest
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
        $validation['title'] = 'bail|required|string|min:3|max:30|not_regex:/[<>~\^\?!\{\}]/';
        return $validation;
    }
}
