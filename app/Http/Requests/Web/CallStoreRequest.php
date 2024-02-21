<?php

namespace App\Http\Requests\Web;

use App\Enum\CallStatusEnum;
use App\Enum\CallTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class CallStoreRequest extends FormRequest
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
            'type'=>'required|in:'.CallTypeEnum::INCOMING.','.CallTypeEnum::OUTGOING,
            'date'=>'required|date',
            'next_action_date'=>'required|date',
            'next_action_note'=>'nullable|string',
            'status'=>'required|in:'.CallStatusEnum::ANSWERED.','.CallStatusEnum::NOT_ANSWERED.','.CallStatusEnum::NOT_AVAILABLE.','.CallStatusEnum::PHONE_CLOSED.','.CallStatusEnum::ERROR_NUMBER,
            'comment'=>'nullable|string',
            'client_id'=>'required|integer|exists:clients,id',
        ];
    }
}
