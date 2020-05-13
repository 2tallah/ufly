<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Address;
use App\Models\MobileVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function profile (Request $request)
    {
        $user = \App\User::query()->find(auth('api')->id());
        $resource = new UserResource($user);
        $resource = json_decode(json_encode($resource),1);
        $resource['token'] = $user->createToken('api')->accessToken;
        return mainResponse(true, __('ok'), $user, $resource, [], 200);
    }

    public function update (Request $request)
    {
        $user_id = auth('api')->id();
        $rules = [
            'image' => 'nullable|image',
            'name' => 'nullable|string|max:255',
            'gender' => 'nullable|string|in:male,female',
            'dob' => 'nullable|date|date_format:Y-m-d',
            'mobile' => 'nullable|numeric|unique:users,mobile,' . $user_id,
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $user_id,
        ];

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return mainResponse(false, $validator->errors()->first(), [], [], $validator->errors()->messages());
        }

        $data = [];

        if ($request->name) {
            $data['name'] = $request->name;
        }
        if ($request->email) {
            $data['email'] = $request->email;
        }
        if ($request->mobile) {
            $data['mobile'] = $request->mobile;
        }
        if ($request->gender) {
            $data['gender'] = $request->gender;
        }
        if ($request->dob) {
            $data['dob'] = $request->dob;
        }
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('public');
            $data['image'] = $image;
        }
        $user = \App\User::query()->find($user_id);
        if (count($data)){
            $user->update($data);
        }
        $resource = new UserResource($user);
        $resource = json_decode(json_encode($resource),1);
        $resource['token'] = $user->createToken('api')->accessToken;
        return mainResponse(true, __('ok'), $user, $resource, [], 200);

    }

    public function updatePassword (Request $request)
    {
        $user = \App\User::query()->find(auth('api')->id());
        $rules = [
            'current_password' => 'required|hash_check:' . $user->getAttribute('password'),
            'password' => 'required|string|min:6',
        ];

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return mainResponse(false, $validator->errors()->first(), [], [], $validator->errors()->messages());
        }
        $user->update(['password' => bcrypt($request->get('password'))]);
        $resource = new UserResource($user);
        $resource = json_decode(json_encode($resource),1);
        $resource['token'] = $user->createToken('api')->accessToken;
        return mainResponse(true, __('ok'), $user, $resource, [], 200);
    }

    public function forgotPassword (Request $request)
    {
        $rules = [
            'email' => 'required|email|exists:users',
        ];
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return mainResponse(false, $validator->errors()->first(), [], [], $validator->errors()->messages());
        }
        return mainResponse(true, 'We sent reset code to your mobile', [], [], [], 200);
    }

}
