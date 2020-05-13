<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'image' => @$this->image,
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'old_price' => $this->old_price,
            'location' => $this->location,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'status' => $this->status_text,
            'category_name' => $this->category->name,
            'coupon_name' => @$this->coupon->name,
            'services' => @$this->services->pluck('name')->toArray(),
            'images' => @$this->images->pluck('image')->toArray(),
        ];
    }
}
