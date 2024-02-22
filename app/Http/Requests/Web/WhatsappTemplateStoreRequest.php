<?php

namespace App\Http\Requests\Web;

use App\Enum\ActivationStatusEnum;
use App\Enum\CallStatusEnum;
use App\Enum\CallTypeEnum;
use App\Enum\ClientStatusEnum;
use Illuminate\Foundation\Http\FormRequest;

class WhatsappTemplateStoreRequest extends FormRequest
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
            'title'=>'required|string',
            'content'=>'required|string',
            'client_status'=>'required|integer|in:'.ClientStatusEnum::NEW.','.ClientStatusEnum::INTERESTED.','.ClientStatusEnum::NOT_INTERESTED.','.ClientStatusEnum::CONTACTED_INCOMING.','.ClientStatusEnum::CONTACTED_OUTGOING.','.ClientStatusEnum::MEETING.','.ClientStatusEnum::PROPOSAL.','.ClientStatusEnum::CLOSED.','.ClientStatusEnum::LOST,
            'comment'=>'nullable|string',
            'is_active'=>'nullable|string',
        ];
    }
}
