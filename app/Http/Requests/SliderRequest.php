<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
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
        $rules = [];
        switch($this->method())
        {
            case 'POST':
                {
                    $rules = [
                        'title' => 'required|max:100|min:1|string',
                        'subtitle' => 'nullable|max:100|min:1|string',
                        'link' => 'nullable|string',
                        'image' => 'required|mimes:jpg,jpeg,png,svg|max:5000',
                    ];
                }
                break;
            case 'PATCH':
                {
                    $rules = [
                        'title' => 'required|max:100|min:1|string',
                        'subtitle' => 'nullable|max:100|min:1|string',
                        'link' => 'nullable|string',
                        'image' => 'mimes:jpg,jpeg,png,svg|max:5000',
                    ];
                }
                break;
            default:
                break;
        }
        return $rules;

    }
}
