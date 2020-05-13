<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserGiftRequest extends FormRequest
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
            'gift_id' => 'required|exists:gifts,id',
        ];
        return $rules;
    }
}
