<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTeacherRequest extends FormRequest
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
        $validation['full_name'] = 'bail|required|string|min:3|max:40|regex:/[A-Za-z\-\'éèêëàâùûô]+/';
        $validation['email'] = 'required|email:filter';
        $validation['phone'] = 'required|regex:/^0( )?3[234]( )?([0-9]( )?){7}$/';
        return $validation;
    }
}
