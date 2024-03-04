<?php

namespace App\Http\Requests\Web;

use App\Enum\ActivationStatusEnum;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'email'=>'required|email',
            'password'=>'required|string|min:8|confirmed',
            'is_active'=>'nullable|string',
            'userTargets_target'=>'nullable|array',
            'userTargets_target.*'=>'required|integer',
            'userTargets_target_value'=>'nullable|array',
            'userTargets_target_value.*'=>'required|integer',
            'userTargets_target_done'=>'nullable|array',
            'userTargets_target_done.*'=>'required|integer',
        ];
    }
}
