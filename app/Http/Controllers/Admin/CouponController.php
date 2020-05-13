<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CouponController extends Controller
{
    public function index()
    {
        return view('admin.coupons.index');
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(CouponRequest $request)
    {
        $data = request()->only('discount_amount');
        foreach (locales() as $key => $language) {
            $data['name'][$key] = $request->get('name_' . $key);
        }
        Coupon::query()->create($data);
        if ($request->ajax()) {
            return response()->json(['status' => true]);
        }
    }

    public function edit($id, Request $request)
    {
        $coupon = Coupon::query()->find($id);
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update($id, CouponRequest $request)
    {
        $coupon = Coupon::query()->find($id);
        $data = request()->only('discount_amount');
        foreach (locales() as $key => $language) {
            if ($request->get('name_' . $key)) {
                $data['name'][$key] = $request->get('name_' . $key);
            }
        }
        $coupon->update($data);
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
            Coupon::query()->whereIn('id', explode(',', $request->ids))
                ->update(['status' => $request->status]);
        } catch (\Exception $e) {
            return response()->json(['status' => false]);
        }
        return response()->json(['status' => true]);
    }

    public function destroy($id)
    {
        try {
            Coupon::query()->whereIn('id', explode(',', $id))->delete();
        } catch (\Exception $e) {
            return response()->json(['status' => false]);
        }
        return response()->json(['status' => true]);
    }

    public function indexTable(Request $request)
    {
        $coupons = Coupon::query();
        return Datatables::of($coupons)
            ->filter(function ($query) use ($request) {
                if ($request->name) {
                    $query->where('name', 'Like', "%$request->name%");
                }
                if (!is_null($request->status)) {
                    $query->where('status', $request->status);
                }
            })->addColumn('action', function ($coupon) {

                $string = '<a  href="' . url('/admin/coupons/' . $coupon->id . '/edit') .
                    '" class="btn btn-sm btn-info"><i class="fa fa-edit"></i>' . __("common.edit") . '</a>';

                $string .= ' <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="' . $coupon->id .
                    '"><i class="fa fa-trash-o"></i>' . __("common.delete") . '</button>';

                return $string;
            })->make(true);
    }

}
