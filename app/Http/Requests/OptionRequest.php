<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OptionRequest extends FormRequest
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
            'title' => 'required',
            'face' => 'required|max:100|min:1',
            'insta' => 'required|max:100|min:1',
            'phone' => 'required',
            'whats' => 'required',
            'email' => 'required',
        ];
    }
}
