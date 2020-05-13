<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{

    public function index(Request $request)
    {
        return view('admin.users.index');

    }

    public function create(Request $request)
    {
        return view('admin.users.create');

    }

    public function store(UserRequest $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('public');
            $data['image'] = $image;
        }
        $data['password'] = bcrypt($request->password);

        $user = User::query()->create($data);
        if ($request->ajax()) {
            return response()->json(['status' => true]);
        }
    }

    public function edit($id, Request $request)
    {
        $user = User::query()->findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update($id, UserRequest $request)
    {
        $user = User::query()->find($id);
        $data = request()->only('name', 'email', 'mobile', 'points');
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('public');
            $data['image'] = $image;
        }
        $user->update($data);
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
            User::query()->whereIn('id', explode(',', $request->ids))->update(['status' => $request->status]);
        } catch (\Exception $e) {
            return response()->json(['status' => false]);
        }
        return response()->json(['status' => true]);
    }

    public function destroy($id, Request $request)
    {
        $users = User::query()->whereIn('id', explode(',', $id))->get();
        foreach ($users as $user) {
            $user->email = 'deleted ' . $user->email;
            $user->mobile = 'deleted ' . $user->mobile;
            $user->name = 'deleted ' . $user->name;
            $user->save();
            $user->delete();
        }
        return response()->json(['status' => true]);
    }

    public function users(Request $request)
    {
        return view('layout.app');

    }


    public function indexTable(Request $request)
    {
        $users = User::query();
        return Datatables::of($users)
            ->filter(function ($query) use ($request) {
                if ($request->get('name')) {
                    $query->where('name', 'like', "%{$request->get('name')}%");
                }
                if ($request->get('email')) {
                    $query->where('email', 'like', "%{$request->get('email')}%");
                }
                if ($request->get('mobile')) {
                    $query->where('mobile', 'like', "%{$request->get('mobile')}%");
                }

//                $request->merge(['length' => -1]);
            })->addColumn('action', function ($user) {
                $string = '<a  href="' . url('/admin/users/' . $user->id . '/edit') . '" class="btn btn-sm btn-info">
                    <i class="fa fa-edit"></i>' . __("common.edit") . '</a>';
                $string .= ' <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="' . $user->id . '">
                    <i class="fa fa-trash-o"></i>' . __("common.delete") . '</button>';
                return $string;
            })
//            ->editColumn('id', 'ID: {{$id}}')

            ->make(true);
    }

}
