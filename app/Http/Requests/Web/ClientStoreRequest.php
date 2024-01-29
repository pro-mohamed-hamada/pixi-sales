<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class ClientStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'=>'required|string',
            'phone'=>'required|string',
            'industry'=>'required|string',
            'company_name'=>'required|string',
            'city_id'=>'required|integer|exists:cities,id',
            'other_person_name'=>'required|string',
            'other_person_phone'=>'required|string',
            'other_person_position'=>'required|string'
        ];
    }
}
