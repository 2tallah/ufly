<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
        if ($this->getMethod() == 'POST') {
            return [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:admins',
                'mobile' => 'required|digits_between:8,14|max:255|unique:admins',
                'password' => 'required|min:6',
            ];

        }
        $id = $this->route('id');
        return [
            'name' => 'required|string|max:255',
            'email' => 'string|email|max:255|unique:admins,email,' . $id,
            'mobile' => 'string|digits_between:8,14|unique:admins,mobile,' . $id,
            'password' => 'nullable|min:6',
        ];
    }
}
