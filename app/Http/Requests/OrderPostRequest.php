<?php

namespace App\Http\Requests;

use App\Enums\Currency;
use App\Rules\AlphaWithSpaceRule;
use App\Rules\NameCapitalizeRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class OrderPostRequest extends FormRequest
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
            'name' => ['required', new AlphaWithSpaceRule(), new NameCapitalizeRule()],
            'price' => ['required', 'numeric', 'max:2000'],
            'currency' => ['required', new Enum(Currency::class)],
            'room_id' => ['required', 'integer'],
            'bnb_id' => ['required', 'integer'],
            'check_in_date' => ['required', 'date'],
            'check_out_date' => ['required', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'price.max' => 'Price is over 2000',
            'currency' => 'CurrencyFacade format is wrong',
        ];
    }
}
