<?php

namespace App\Http\Requests\Api;

use App\Enum\ClientStatusEnum;
use Illuminate\Foundation\Http\FormRequest;

class ClientHistoryStoreRequest extends FormRequest
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
            'status'=>'required|integer|in:'.ClientStatusEnum::CONTACTED_INCOMING.','.ClientStatusEnum::CONTACTED_OUTGOING.','.ClientStatusEnum::INTERESTED.','.ClientStatusEnum::NOT_INTERESTED.','.ClientStatusEnum::PROPOSAL.','.ClientStatusEnum::MEETING.','.ClientStatusEnum::CLOSED.','.ClientStatusEnum::LOST,
            'reason_id'=>'nullable|exists:reasons,id',
            'comment'=>'nullable|string',
        ];
    }
}
