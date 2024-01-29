<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;
use App\Enum\ActionTypeEnum;
class VisitStoreRequest extends FormRequest
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
            'action_type'=>'required|in:'.ActionTypeEnum::CALL.','.ActionTypeEnum::SMS.','.ActionTypeEnum::WHATSAPP,
            'comment'=>'nullable|string',
        ];
    }
}
