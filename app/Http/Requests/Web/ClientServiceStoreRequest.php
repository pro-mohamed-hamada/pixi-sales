<?php

namespace App\Http\Requests\Web;

use App\Enum\CurrencyEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientServiceStoreRequest extends FormRequest
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
            'service_id' => [
                'required',
                'integer',
                'exists:services,id',
                Rule::unique('client_services')->where(function ($query) {
                    return $query->where('client_id', $this->client_id);
                }),
            ],
            'price'=>'required|numeric',
            'currency'=>'required|string|in:'.CurrencyEnum::EGP.','.CurrencyEnum::USD,
        ];
    }
}
