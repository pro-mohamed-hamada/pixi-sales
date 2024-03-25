<?php

namespace App\Http\Requests\Api;

use App\Enum\ActionTypeEnum;
use App\Enum\CallStatusEnum;
use App\Enum\CallTypeEnum;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
            'id'=>'required|integer',
            'task_table'=>'required|string|in:visit,call,meeting,client_service',
        ];
    }
}
