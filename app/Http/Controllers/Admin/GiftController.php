<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GiftRequest;
use App\Models\Gift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class GiftController extends Controller
{
    public function index()
    {
        return view('admin.gifts.index');
    }

    public function create()
    {
        return view('admin.gifts.create');
    }

    public function store(GiftRequest $request)
    {
        $data = request()->only('points');
        foreach (locales() as $key => $language) {
            $data['name'][$key] = $request->get('name_' . $key);
            $data['details'][$key] = $request->get('details_' . $key);
        }
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('public');
            $data['image'] = $image;
        }
        Gift::query()->create($data);
        if ($request->ajax()) {
            return response()->json(['status' => true]);
        }
    }

    public function edit($id, Request $request)
    {
        $gift = Gift::query()->find($id);
        return view('admin.gifts.edit', compact('gift'));
    }

    public function update($id, GiftRequest $request)
    {
        $gift = Gift::query()->find($id);
        $data = request()->only('points');
        foreach (locales() as $key => $language) {
            if ($request->get('name_' . $key)) {
                $data['name'][$key] = $request->get('name_' . $key);
            }
            if ($request->get('details_' . $key)) {
                $data['details'][$key] = $request->get('details_' . $key);
            }
        }
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('public');
            $data['image'] = $image;
        }
        $gift->update($data);
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
            Gift::query()->whereIn('id', explode(',', $request->ids))
                ->update(['status' => $request->status]);
        } catch (\Exception $e) {
            return response()->json(['status' => false]);
        }
        return response()->json(['status' => true]);
    }

    public function destroy($id)
    {
        try {
            Gift::query()->whereIn('id', explode(',', $id))->delete();
        } catch (\Exception $e) {
            return response()->json(['status' => false]);
        }
        return response()->json(['status' => true]);
    }

    public function indexTable(Request $request)
    {
        $gifts = Gift::query();
        return Datatables::of($gifts)
            ->filter(function ($query) use ($request) {
                if ($request->name) {
                    $query->where('name', 'Like', "%$request->name%");
                }
                if (!is_null($request->status)) {
                    $query->where('status', $request->status);
                }
            })->addColumn('action', function ($gift) {

                $string = '<a  href="' . url('/admin/gifts/' . $gift->id . '/edit') .
                    '" class="btn btn-sm btn-info"><i class="fa fa-edit"></i>' . __("common.edit") . '</a>';

                $string .= ' <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="' . $gift->id .
                    '"><i class="fa fa-trash-o"></i>' . __("common.delete") . '</button>';

                return $string;
            })->make(true);
    }

}
