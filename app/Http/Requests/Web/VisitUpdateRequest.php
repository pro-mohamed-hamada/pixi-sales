<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;
use App\Enum\ActionTypeEnum;
use Carbon\Carbon;

class VisitUpdateRequest extends FormRequest
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
            'client_id'=>'required|integer|exists:clients,id',
            'date'=>'required|date',
            'city_id'=>'required|integer|exists:cities,id',
            'next_action'=>'nullable|required_with:next_action_date|integer|in:'.ActionTypeEnum::CALL.','.ActionTypeEnum::MEETING.','.ActionTypeEnum::WHATSAPP.','.ActionTypeEnum::VISIT,
            'next_action_date'=>'nullable|required_with:next_action|date|after:'.Carbon::now(),
            'comment'=>'nullable|string',
            'person_position'=>'nullable|string',
        ];
    }
}
