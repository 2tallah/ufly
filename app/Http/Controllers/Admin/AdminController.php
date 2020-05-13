<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{

    public function index(Request $request)
    {
        return view('admin.admins.index', compact('brands', 'parts', 'suppliers'));

    }

    public function create(Request $request)
    {
        return view('admin.admins.create');

    }

    public function store(AdminRequest $request)
    {
        $data = request()->except('image', 'password', 'permissions');
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('public');
            $data['image'] = $image;
        }
        $data['password'] = bcrypt($request->password);

        Admin::query()->create($data);
        if ($request->ajax()) {
            return response()->json(['status' => true]);
        }
    }

    public function edit($id, Request $request)
    {
        $admin = Admin::query()->findOrFail($id);
        return view('admin.admins.edit', compact('admin'));
    }

    public function update($id, AdminRequest $request)
    {
        $admin = Admin::query()->find($id);
        $data = request()->except('image', 'password', 'permissions');
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('public');
            $data['image'] = $image;
        }
        $admin->update($data);
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
            Admin::query()->whereIn('id', explode(',', $request->ids))->update(['status' => $request->status]);
        } catch (\Exception $e) {
            return response()->json(['status' => false]);
        }
        return response()->json(['status' => true]);
    }

    public function destroy($id, Request $request)
    {
        $admins = Admin::query()->whereIn('id', explode(',', $id))->get();
        foreach ($admins as $admin) {
            $admin->email = 'deleted ' . $admin->email;
            $admin->mobile = 'deleted ' . $admin->mobile;
            $admin->name = 'deleted ' . $admin->name;
            $admin->save();
            $admin->delete();
        }
        return response()->json(['status' => true]);
    }

    public function admins(Request $request)
    {
        return view('layout.app');

    }


    public function indexTable(Request $request)
    {
//        dd($request->get('category_id'));
        $admins = Admin::query()->where('id', '<>', 1)/*->orderBy('id', 'desc')*/
        ;
        return Datatables::of($admins)
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
            })->addColumn('action', function ($admin) {
                $string = '<a  href="' . url('/admin/admins/' . $admin->id . '/edit') . '" class="btn btn-sm btn-info">
                    <i class="fa fa-edit"></i>' . __("common.edit") . '</a>';
                $string .= ' <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="' . $admin->id . '">
                    <i class="fa fa-trash-o"></i>' . __("common.delete") . '</button>';
                return $string;
            })
//            ->editColumn('id', 'ID: {{$id}}')

            ->make(true);
    }

}
