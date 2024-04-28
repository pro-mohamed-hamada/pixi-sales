<?php

namespace App\Http\Requests\Web;

use App\Enum\FcmEventsNames;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FcmMessageStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|string',
            'content' => 'required|string',
            'is_active' => 'nullable|string',
            'fcm_action' => ['required','unique:fcm_messages,fcm_action',Rule::in(array_keys(FcmEventsNames::$FCMACTIONS))],
            'notification_via'=>'required',
        ];
    }
}
