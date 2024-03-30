<?php

namespace App\Http\Requests\Api;

use App\Enum\ClientSourceEnum;
use App\Enum\ClientStatusEnum;
use Illuminate\Foundation\Http\FormRequest;

class ReassignClientRequest
 extends FormRequest
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
            'assigned_to'=>'nullable|integer|exists:users,id',
        ];
    }
}
