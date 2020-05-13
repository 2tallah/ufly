<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OfferRequest;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Offer;
use App\Models\OfferImage;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class OfferController extends Controller
{
    public function index()
    {
        $categories = Category::query()->get();
        $coupons = Coupon::query()->get();
        $services = Service::query()->get();
        return view('admin.offers.index', compact('categories', 'coupons', 'services'));
    }

    public function create()
    {
        $categories = Category::query()->get();
        $coupons = Coupon::query()->get();
        $services = Service::query()->get();
        return view('admin.offers.create', compact('categories', 'coupons', 'services'));
    }

    public function store(OfferRequest $request)
    {
        $data = request()->only('category_id', 'coupon_id', 'price', 'old_price', 'rating', 'location', 'lat', 'lng');
        foreach (locales() as $key => $language) {
            $data['title'][$key] = $request->get('title_' . $key);
            $data['description'][$key] = $request->get('description_' . $key);
        }
        $offer = Offer::query()->create($data);
        $offer->services()->sync($request->services);
        $images = [];
        foreach ($request->images as $image) {
            $image = $image->store('public');
            $images[] = ['offer_id' => $offer->id, 'image' => $image,
                'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        }
        OfferImage::query()->insert($images);
        if ($request->ajax()) {
            return response()->json(['status' => true]);
        }
    }

    public function edit($id, Request $request)
    {
        $offer = Offer::query()->find($id);
        $categories = Category::query()->get();
        $coupons = Coupon::query()->get();
        $services = Service::query()->get();
        return view('admin.offers.edit', compact('offer', 'categories', 'coupons', 'services'));
    }

    public function update($id, OfferRequest $request)
    {
        $offer = Offer::query()->find($id);
        $data = request()->only('category_id', 'coupon_id', 'price', 'old_price', 'rating', 'location', 'lat', 'lng');
        foreach (locales() as $key => $language) {
            if ($request->get('name_' . $key)) {
                $data['name'][$key] = $request->get('name_' . $key);
                $data['description'][$key] = $request->get('description_' . $key);
            }
        }
        $offer->update($data);
        $offer->services()->sync($request->services);
        if ($request->delete_ids) {
            OfferImage::query()->whereIn('id', $request->delete_ids)
                ->where('offer_id', $offer->id)->delete();
        }
        if ($request->images) {
            $images = [];
            foreach ($request->images as $image) {
                $image = $image->store('public');
                $images[] = ['offer_id' => $offer->id, 'image' => $image,
                    'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
            }
            OfferImage::query()->insert($images);
        }
        if ($request->ajax()) {
            return response()->json(['status' => true]);
        }
    }


    public function updateStatus(Request $request)
    {
        $rules = [
            'ids' => 'required',
            'status' => 'required|in:0,1',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => false]);
        }
        try {
            Offer::query()->whereIn('id', explode(',', $request->ids))
                ->update(['status' => $request->status]);
        } catch (\Exception $e) {
            return response()->json(['status' => false]);
        }
        return response()->json(['status' => true]);
    }

    public function destroy($id)
    {
        try {
            Offer::query()->whereIn('id', explode(',', $id))->delete();
        } catch (\Exception $e) {
            return response()->json(['status' => false]);
        }
        return response()->json(['status' => true]);
    }

    public function indexTable(Request $request)
    {
        $offers = Offer::query();
        return Datatables::of($offers)
            ->filter(function ($query) use ($request) {
                if ($request->title) {
                    $query->where('title', 'Like', "%$request->title%");
                }
                if ($request->category_id) {
                    $query->where('category_id', $request->category_id);
                }
                if ($request->coupon_id) {
                    $query->where('coupon_id', $request->coupon_id);
                }
                if (!is_null($request->status)) {
                    $query->where('status', $request->status);
                }
            })->addColumn('action', function ($offer) {

                $string = '<a  href="' . url('/admin/offers/' . $offer->id . '/edit') .
                    '" class="btn btn-sm btn-info"><i class="fa fa-edit"></i>' . __("common.edit") . '</a>';

                $string .= ' <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="' . $offer->id .
                    '"><i class="fa fa-trash-o"></i>' . __("common.delete") . '</button>';

                return $string;
            })->make(true);
    }

}
