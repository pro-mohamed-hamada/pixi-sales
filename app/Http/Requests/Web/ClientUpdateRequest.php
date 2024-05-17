<?php

namespace App\Http\Requests\Web;

use App\Enum\ActionTypeEnum;
use App\Enum\ClientSourceEnum;
use App\Enum\ClientStatusEnum;
use App\Enum\CurrencyEnum;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class ClientUpdateRequest extends FormRequest
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
            'phone'=>['required', 'string', 'unique:clients,phone,'.$this->client, 'unique:clients,other_person_phone,'.$this->client],
            'industry_id'=>'required|integer|exists:industries,id',
            'company_name'=>'required|string',
            'city_id'=>'required|integer|exists:cities,id',
            'other_person_name'=>'required|string',
            'other_person_phone'=>['required', 'string', 'unique:clients,phone,'.$this->client, 'unique:clients,other_person_phone,'.$this->client],
            'other_person_position'=>'required|string',
            'facebook_url'=>'nullable|url',
            'source_id'=>'required|integer|exists:sources,id',
            'assigned_to'=>'required|integer|exists:users,id',

            'status'=>'required|integer|in:'.ClientStatusEnum::NEW.','.ClientStatusEnum::CONTACTED.','.ClientStatusEnum::INTERESTED.','.ClientStatusEnum::NOT_INTERESTED.','.ClientStatusEnum::PROPOSAL.','.ClientStatusEnum::MEETING.','.ClientStatusEnum::CLOSED.','.ClientStatusEnum::LOST,
            'reason_id'=>'nullable|exists:reasons,id|required_if:status,'.ClientStatusEnum::NOT_INTERESTED.','.ClientStatusEnum::LOST,
            'comment'=>'nullable|string|required_if:status,'.ClientStatusEnum::NOT_INTERESTED,

            'services'=>'nullable|array',
            'services.*'=>'required|integer|exists:services,id',
            'prices'=>'nullable|array',
            'prices.*'=>'nullable|required_with:services.*|numeric',
            'curriencies'=>'nullable|array',
            'currencies.*'=>'nullable|required_with:services.*|string|in:'.CurrencyEnum::EGP.','.CurrencyEnum::USD,
            'next_action'=>'nullable|required_with:next_action_date|integer|in:'.ActionTypeEnum::CALL.','.ActionTypeEnum::MEETING.','.ActionTypeEnum::WHATSAPP.','.ActionTypeEnum::VISIT,
            'next_action_date'=>'nullable|required_with:next_action|date|after:'.Carbon::now(),
            'comment'=>'nullable|string',
        ];
    }
}
