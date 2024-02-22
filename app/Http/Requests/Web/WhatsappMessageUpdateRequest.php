<?php

namespace App\Http\Requests\Web;

use App\Enum\CallStatusEnum;
use App\Enum\CallTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class WhatsappMessageUpdateRequest extends FormRequest
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
            'whatsapp_template_id'=>'required|integer|exists:whatsapp_templates,id',
            'client_id'=>'required|integer|exists:clients,id',
        ];
    }
}
