<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDepartmentRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'description' => 'required|regex:/^[a-zA-Z ]+$/',
            'wallet_id' => 'required|integer',
            'type' => 'required|in:c,bt,mb',
            'transfer_movement_id' => 'integer',
            'transfer_wallet_id' => 'integer',
            'type_payment' => 'required|in:i,e',
            'category_id' => 'required|integer',
            'iban' => 'required|string|max:24',
            'mb_entity_code' => 'integer|regex:/\b\d{5}\b/g',
            'mb_payment_reference' => 'integer|regez:/\b\d{9}\b/g',
            'start_balance'=> 'required|float',
            'end_balance' => 'required|float',
            'value' => 'required|float',
        ];
    }
}
