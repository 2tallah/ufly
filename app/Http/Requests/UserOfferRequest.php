<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserOfferRequest extends FormRequest
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
        $rules = [
            'user_id' => 'required|exists:users,id',
            'offer_id' => 'required|exists:offers,id',
            'quantity' => 'required|numeric',
        ];
        return $rules;
    }
}
