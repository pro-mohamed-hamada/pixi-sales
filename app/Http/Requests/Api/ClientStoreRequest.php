<?php

namespace App\Http\Requests\Api;

use App\Enum\ClientSourceEnum;
use App\Enum\ClientStatusEnum;
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
            'phone'=>['required', 'string', 'unique:clients,phone', 'unique:clients,other_person_phone'],
            'industry_id'=>'required|integer|exists:industries,id',
            'company_name'=>'required|string',
            'city_id'=>'required|integer|exists:cities,id',
            'other_person_name'=>'nullable|string',
            'other_person_phone'=>['nullable', 'string', 'unique:clients,phone', 'unique:clients,other_person_phone'],
            'other_person_position'=>'nullable|string',
            'facebook_url'=>'nullable|url',
            'source_id'=>'required|integer|exists:sources,id',
            'assigned_to'=>'nullable|integer|exists:users,id',

            'status'=>'required|integer|in:'.ClientStatusEnum::NEW.','.ClientStatusEnum::CONTACTED.','.ClientStatusEnum::INTERESTED.','.ClientStatusEnum::NOT_INTERESTED.','.ClientStatusEnum::PROPOSAL.','.ClientStatusEnum::MEETING.','.ClientStatusEnum::CLOSED.','.ClientStatusEnum::LOST,
            'reason_id'=>'nullable|exists:reasons,id|required_if:status,'.ClientStatusEnum::NOT_INTERESTED.','.ClientStatusEnum::LOST,
            'comment'=>'nullable|string|required_if:status,'.ClientStatusEnum::NOT_INTERESTED,

            'lat'=>'nullable|numeric',
            'lng'=>'nullable|numeric',
        ];
    }
}
