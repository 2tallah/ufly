<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\GiftResource;
use App\Http\Resources\OfferResource;
use App\Http\Resources\UserGiftResource;
use App\Models\Category;
use App\Models\Gift;
use App\Models\Offer;
use App\Models\UserGift;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function categories (Request $request)
    {
        $categories = Category::query()->where('status', 1)->paginate();
        $resource = CategoryResource::collection($categories);
//        $resource = new Collection($resource);
        return mainResponse(true, __('ok'), $categories, $resource, [], 200);
    }
    public function gifts (Request $request)
    {
        $gifts = Gift::query()->where('status', 1)->paginate();
        $resource = GiftResource::collection($gifts);
        $resource->additional(['key' => 'value']);
        return mainResponse(true, __('ok'), $gifts, $resource, [], 200);
    }
    public function myGifts (Request $request)
    {
        $gifts = UserGift::query()->paginate();
        $resource = UserGiftResource::collection($gifts);
        return mainResponse(true, __('ok'), $gifts, $resource, [], 200);
    }
    public function offers (Request $request)
    {
        $offers = Offer::query();
        if ($request->search){
            $offers->where(function ($q) use ($request){
                $q->where('name', 'like', "%$request->search%")->
                    where('details', 'like', "%$request->search%");
            });
        }
        if ($request->category_id){
            $offers->where('category_id', $request->category_id);
        }
        if ($request->category_id){
            $offers->where('category_id', $request->category_id);
        }
        $offers = $offers->where('status', 1)->orderByDesc('id')->paginate(2);
        $resource = OfferResource::collection($offers);
        return mainResponse(true, __('ok'), $offers, $resource, [], 200);
    }

}
