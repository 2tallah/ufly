<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\AffiliateCode;
use App\Models\AffiliateUser;
use App\Models\MobileToken;
use App\Admin;
use App\Models\MobileVerification;
use App\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:api');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'device' => 'required|string|max:255',
            'token' => 'required|string|max:255',
            'mobile' => 'required|digits_between:8,14|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $data = $request->all();
        $validator = $this->validator($data);
        if ($validator->fails()) {
            return mainResponse(false, $validator->errors()->first(), (object)[], (object)[], $validator->errors()->messages(), 200);
        }


        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('public');
            $data['image'] = $image;
        }
        event(new Registered($user = $this->create($data)));
        $user = User::query()->find($user->id);

/*        MobileToken::query()->updateOrCreate(
            ['user_id' => $user->id, 'token' => $request->token, 'device' => $request->device],
            ['user_id' => $user->id, 'token' => $request->token, 'device' => $request->device]);*/
//        $user->setAttribute('token', $user->createToken('app')->accessToken);
        $resource = new UserResource($user);
        $resource = json_decode(json_encode($resource),1);
        $resource['token'] = $user->createToken('api')->accessToken;
        return mainResponse(true, __('ok'), $user, $resource, [], 200);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'mobile' => $data['mobile'],
            'gender' => $data['gender'],
            'dob' => $data['dob'],
            'password' => bcrypt($data['password']),
        ]);

        return $user;
    }
}
