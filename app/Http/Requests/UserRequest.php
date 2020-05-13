<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
                'email' => 'required|string|email|max:255|unique:users',
                'mobile' => 'required|digits_between:8,14|max:255|unique:users',
                'password' => 'required|min:6',
                'points' => 'nullable|numeric',
                'image' => 'nullable|image',
            ];

        }
        $id = $this->route('id');
        return [
            'name' => 'required|string|max:255',
            'email' => 'string|email|max:255|unique:users,email,' . $id,
            'mobile' => 'string|digits_between:8,14|unique:users,mobile,' . $id,
            'password' => 'nullable|min:6',
            'points' => 'nullable|numeric',
            'image' => 'nullable|image',
        ];
    }
}
