<?php

namespace App\Http\Requests\Web;

use App\Enum\ClientStatusEnum;
use Illuminate\Foundation\Http\FormRequest;

class ClientHistoryRequest extends FormRequest
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
            'status'=>'required|integer|in:'.ClientStatusEnum::NEW.','.ClientStatusEnum::CONTACTED.','.ClientStatusEnum::INTERESTED.','.ClientStatusEnum::NOT_INTERESTED.','.ClientStatusEnum::PROPOSAL.','.ClientStatusEnum::MEETING.','.ClientStatusEnum::CLOSED.','.ClientStatusEnum::LOST,
            'reason_id'=>'nullable|exists:reasons,id|required_if:status,'.ClientStatusEnum::NOT_INTERESTED,
            'comment'=>'nullable|string|required_if:status,'.ClientStatusEnum::NOT_INTERESTED,
            'date_time'=>'nullable|date|required_if:status,'.ClientStatusEnum::CONTACTED.'|'.'required_if:status,'.ClientStatusEnum::MEETING,
        ];
    }
}
