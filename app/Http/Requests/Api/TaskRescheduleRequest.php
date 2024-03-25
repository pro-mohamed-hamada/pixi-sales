<?php

namespace App\Http\Requests\Api;

use App\Enum\ActionTypeEnum;
use App\Enum\CallStatusEnum;
use App\Enum\CallTypeEnum;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class TaskRescheduleRequest extends FormRequest
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
            'task_table'=>'required|string|in:visit,call,meeting,client_service',
            'date'=>'required|date|after:'.Carbon::now(),
        ];
    }
}
