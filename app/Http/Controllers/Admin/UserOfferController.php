<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserOfferRequest;
use App\Models\Offer;
use App\Models\UserOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UserOfferController extends Controller
{
    public function index()
    {
        $offers = Offer::query()->get();
        return view('admin.user_offers.index', compact('offers'));
    }

    public function create()
    {
        $offers = Offer::query()->get();
        return view('admin.user_offers.create', compact('offers'));
    }

    public function store(UserOfferRequest $request)
    {
        $data = request()->only('user_id', 'offer_id', 'quantity');
        $offer = Offer::query()->find($request->offer_id);
        if ($offer) {
            $data['coupon_id'] = @$offer->coupon_id;
            $data['price'] = @$offer->price;
            $data['discount_amount'] = @$offer->coupon->discount_amount ?? 0;
            $data['total'] = (@$offer->price + @$offer->coupon->discount_amount) * $request->quantity;
        }
        UserOffer::query()->create($data);
        if ($request->ajax()) {
            return response()->json(['status' => true]);
        }
    }

    public function edit($id, Request $request)
    {
        $user_offer = UserOffer::query()->find($id);
        $offers = Offer::query()->get();
        return view('admin.user_offers.edit', compact('user_offer', 'offers'));
    }

    public function update($id, UserOfferRequest $request)
    {
        $user_offer = UserOffer::query()->find($id);
        $data = request()->only('user_id', 'offer_id', 'quantity');
        $offer = Offer::query()->find($request->offer_id);
        if ($offer) {
            $data['coupon_id'] = @$offer->coupon_id;
            $data['price'] = @$offer->price;
            $data['discount_amount'] = @$offer->coupon->discount_amount ?? 0;
            $data['total'] = (@$offer->price + @$offer->coupon->discount_amount) * $request->quantity;
        }
        $user_offer->update($data);
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
            UserOffer::query()->whereIn('id', explode(',', $request->ids))
                ->update(['status' => $request->status]);
        } catch (\Exception $e) {
            return response()->json(['status' => false]);
        }
        return response()->json(['status' => true]);
    }

    public function destroy($id)
    {
        try {
            UserOffer::query()->whereIn('id', explode(',', $id))->delete();
        } catch (\Exception $e) {
            return response()->json(['status' => false]);
        }
        return response()->json(['status' => true]);
    }

    public function indexTable(Request $request)
    {
        $user_offers = UserOffer::query();
        return Datatables::of($user_offers)
            ->filter(function ($query) use ($request) {
                if ($request->user_id) {
                    $query->where('user_id', $request->user_id);
                }
                if ($request->offer_id) {
                    $query->where('offer_id', $request->offer_id);
                }
            })->addColumn('action', function ($user_offer) {

                $string = '<a  href="' . url('/admin/user_offers/' . $user_offer->id . '/edit') .
                    '" class="btn btn-sm btn-info"><i class="fa fa-edit"></i>' . __("common.edit") . '</a>';

                $string .= ' <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="' . $user_offer->id .
                    '"><i class="fa fa-trash-o"></i>' . __("common.delete") . '</button>';

                return $string;
            })->make(true);
    }

}
