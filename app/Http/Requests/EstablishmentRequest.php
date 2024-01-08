<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstablishmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->is_super_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'=>'string|max:150|required',
            'name_en'=>'string|max:150|required|unique:establishments,name_en'.$this->id,
            'bio'=>'string|max:400',
            'email'=>'string|max:150',
            'phone1'=>'string|max:150|required',
            'phone2'=>'string|max:150',
            'whatstapp_number'=>'string|max:150',
            'website_link'=>'string',
            'address'=>'string|max:150',
            'currency'=>'string|max:150|required',
            'commercial_register_number'=>'numeric|required',
            'commercial_register_photo'=>'string|required',
            'commercial_register_end_at'=>'required|date',
            'tax_number'=>'integer|required',
            'tax_certificate_image'=>'string|required',
            'license_number'=>'integer|required',
            'license_image' =>'string|required',
            'evaluation_branch'=>'string|max:150',
            'evaluation_end_date'=>'date',
            // 'domain'=>'string|max:150|required',
            // 'database'=>'string|max:150|required',
        ];
    }
}
