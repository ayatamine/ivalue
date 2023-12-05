<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientEstateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->membership_level =='client';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];
        switch($this->method())
        {
            case 'POST':
                {
                    $rules = [
//                        'name_english' => 'required|max:100|min:1|string',
                        'name_arabic' => 'sometimes|max:100|min:1|string',
                        'address' => 'required|min:1|string',
                        'about' => 'required|min:1|string',
                        // 'level' => 'required',
                        // 'age' => 'required',
                        // 'user_id' => 'required',
                        // 'category_id' => 'required',
                        'kind_id' => 'required',
//                        'image' => 'required|mimes:jpg,jpeg,png,svg|max:5000',
                        'files*' => 'required',
                    ];
                }
                break;
            case 'PATCH':
                {
                    $rules = [
                        'name_english' => 'required|max:100|min:1|string',
                        'name_arabic' => 'required|max:100|min:1|string',
                        'address' => 'required|min:1|string',
                        'about' => 'required|min:1|string',
                        // 'level' => 'required',
                        // 'age' => 'required',
                        'image' => 'mimes:jpg,jpeg,png,svg|max:5000',
                        'user_id' => 'required',
                        // 'category_id' => 'required',
                        'kind_id' => 'required',
                    ];
                }
                break;
            default:
                break;
        }
        return $rules;

    }
}
