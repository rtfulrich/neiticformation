<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateFormationSessionRequest extends FormRequest
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

        $validation['title'] = preg_match('#^s[0-9]+$#', request('title')) ? 'bail|not_regex:/^s0$/' : 'bail|required|string|min:3|max:30|not_regex:/[<>~\^\?!\{\}]/';
        $validation['date_debut'] = 'required|date';
        $validation['date_end'] = 'required|date|after:date_debut';
        $validation['fee'] = 'required|integer|min:0';
        $validation['teacher'] = preg_match('#^s[0-9]+$#' ,request('teacher')) ? 'bail|not_regex:/^s0$/' : 'bail|required|string|min:3|max:40|regex:/[A-Za-z\-\'éèêëàâùûô]+/';
        if (!preg_match('#^s[1-9]+$#', request('teacher'))) {
            $validation['email'] = 'required|email:filter|unique:teachers';
            $validation['phone'] = 'required|regex:/^0( )?3[234]( )?([0-9]( )?){7}$/|unique:students|unique:teachers';
        }

        return $validation;
        
        // return [
        //     'title_input' => 'required_if:title_select,none|min:3|max:50',
        //     'title_select' => 'required_if:title_input,none|numeric',
        //     'date_debut' => 'required|date',
        //     'date_end' => 'date|after:date_debut',
        //     'fee' => 'required|integer',
        //     'teacher_input' => 'required_if:teacher_select,none|min:3|max:30',
        //     'teacher_select' => 'required_if:teacher_input,none|numeric',
        //     'teacher_email' => 'required_if:teacher_select,none|email',
        //     'teacher_phone' => 'required_if:teacher_select,none|regex:/^03[234][0-9]{7}$/'
        // ];
    }
}
