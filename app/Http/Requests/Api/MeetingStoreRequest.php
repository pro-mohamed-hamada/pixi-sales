<?php

namespace App\Http\Requests\Api;

use App\Enum\CallStatusEnum;
use App\Enum\CallTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class MeetingStoreRequest extends FormRequest
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
            'date'=>'required|date',
            'client_id'=>'required|integer|exists:clients,id',
            'comment'=>'nullable|string',
        ];
    }
}
