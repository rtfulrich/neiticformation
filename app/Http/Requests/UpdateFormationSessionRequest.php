<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFormationSessionRequest extends FormRequest
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

        $validation['date_debut'] = 'required|date';
        if (!is_null(request('date_end'))) $validation['date_end'] = 'date|after:date_debut';
        $validation['fee'] = 'required|integer|min:0';
        $validation['teacher'] = preg_match('#^s[0-9]+$#' ,request('teacher')) ? 'bail|not_regex:/^s0$/' : 'bail|required|string|min:3|max:40|regex:/[A-Za-z\-\'éèêëàâùûô]+/';
        if (!preg_match('#^s[1-9]+$#', request('teacher'))) {
            $validation['email'] = 'required|email:filter|unique:teachers';
            $validation['phone'] = 'required|regex:/^03[234][0-9]{7}$/|unique:teachers';
        }

        return $validation;
    }
}