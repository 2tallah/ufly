<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfferRequest extends FormRequest
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
            'category_id' => 'required|exists:categories,id',
            'coupon_id' => 'required|exists:coupons,id',
            'services' => 'required|array',
            'services.*' => 'required|exists:services,id',
            'images' => 'required|array',
            'images.*' => 'required|image',
            'price' => 'required|numeric',
            'old_price' => 'nullable|numeric',
            'rating' => 'nullable|numeric|in:1,2,3,4,5',
            'location' => 'nullable|string',
            'lat' => 'nullable',
            'lng' => 'nullable',
        ];
        foreach (locales() as $key => $language) {
            $rules['title_' . $key] = 'required|string|max:255';
            $rules['description_' . $key] = 'required|string|max:255';
        }

        if ($this->getMethod() == 'POST') {
            $rules += [
                'images' => 'required|array',
                'images.*' => 'required|image'];
        }
        if ($this->getMethod() == 'PUT') {
            $rules += [
                'images' => 'nullable|array',
                'images.*' => 'nullable|image'];
        }
        return $rules;

    }
}
