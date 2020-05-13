<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserGiftRequest;
use App\Models\Gift;
use App\Models\UserGift;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UserGiftController extends Controller
{
    public function index()
    {
        $gifts = Gift::query()->get();
        return view('admin.user_gifts.index', compact('gifts'));
    }

    public function create()
    {
        $gifts = Gift::query()->get();
        return view('admin.user_gifts.create', compact('gifts'));
    }

    public function store(UserGiftRequest $request)
    {
        $data = request()->only('user_id', 'gift_id');
        $gift = Gift::query()->find($request->gift_id);
        if ($gift) {
            $data['name'] = @$gift->getOriginal('name');
            $data['details'] = @$gift->getOriginal('details');
            $data['image'] = @$gift->getAttributes()['image'];
            $data['points'] = @$gift->points;
        }
        $user = User::query()->find($request->user_id);
        $user->update(['points' => $user->points - $request->points]);
        UserGift::query()->create($data);
        if ($request->ajax()) {
            return response()->json(['status' => true]);
        }
    }

    public function edit($id, Request $request)
    {
        $user_gift = UserGift::query()->find($id);
        $gifts = Gift::query()->get();
        return view('admin.user_gifts.edit', compact('user_gift', 'gifts'));
    }

    public function update($id, UserGiftRequest $request)
    {
        $user_gift = UserGift::query()->find($id);
        $data = request()->only('user_id', 'gift_id');
        $gift = Gift::query()->find($request->gift_id);
        if ($gift) {
            $data['name'] = @$gift->getOriginal('name');
            $data['details'] = @$gift->getOriginal('details');
            $data['image'] = @$gift->getAttributes()['image'];
            $data['points'] = @$gift->points;
        }
        $user_gift->update($data);
        $user = User::query()->find($request->user_id);
        $user->update(['points' => $user->points + $user_gift->points - $request->points]);
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
            UserGift::query()->whereIn('id', explode(',', $request->ids))
                ->update(['status' => $request->status]);
        } catch (\Exception $e) {
            return response()->json(['status' => false]);
        }
        return response()->json(['status' => true]);
    }

    public function destroy($id)
    {
        try {
            UserGift::query()->whereIn('id', explode(',', $id))->delete();
        } catch (\Exception $e) {
            return response()->json(['status' => false]);
        }
        return response()->json(['status' => true]);
    }

    public function indexTable(Request $request)
    {
        $user_gifts = UserGift::query();
        return Datatables::of($user_gifts)
            ->filter(function ($query) use ($request) {
                if ($request->user_id) {
                    $query->where('user_id', $request->user_id);
                }
                if ($request->gift_id) {
                    $query->where('gift_id', $request->gift_id);
                }
            })->addColumn('action', function ($user_gift) {

                $string = '<a  href="' . url('/admin/user_gifts/' . $user_gift->id . '/edit') .
                    '" class="btn btn-sm btn-info"><i class="fa fa-edit"></i>' . __("common.edit") . '</a>';

                $string .= ' <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="' . $user_gift->id .
                    '"><i class="fa fa-trash-o"></i>' . __("common.delete") . '</button>';

                return $string;
            })->make(true);
    }

}
