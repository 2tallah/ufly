<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\User;
//use App\Models\MobileToken;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Lcobucci\JWT\Parser;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest:api')->except('logout');
    }

    protected function guard()
    {
        return Auth::guard('api-teacher');
    }


    protected function validator(array $data)
    {
        $rules = [
            $this->username() => 'required|email',
            'password' => 'required|string',
            'token' => 'required|string|max:255',
            'device' => 'required|string|max:255',
        ];

        return Validator::make($data, $rules);
    }

    public function login(Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return mainResponse(false, $validator->errors()->first(), (object)[], (object)[], $validator->errors()->messages(), 200);
        }

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            $user = auth()->guard()->user();
/*            if (!$user->status){
                $this->incrementLoginAttempts($request);
                return mainResponse(false, __('account_inactive'), (object)[], [], 200);

            }*/
            $this->clearLoginAttempts($request);
//            $user->update(['fcm_token' => $request->fcm_token, 'device' => $request->device]);
            $user = User::query()->find($user->id);
/*            MobileToken::query()->updateOrCreate(
                ['user_id' => $user->id, 'token' => $request->token, 'device' => $request->device],
                ['user_id' => $user->id, 'token' => $request->token, 'device' => $request->device]);*/
//            $user->setAttribute('token', $user->createToken('api')->accessToken);
            $resource = new UserResource($user);
            $resource = json_decode(json_encode($resource),1);
            $resource['token'] = $user->createToken('api')->accessToken;
            return mainResponse(true, __('ok'), $user, $resource, [], 200);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );
        return mainResponse(false, __('auth.throttle', ['seconds' => $seconds]), (object)[], (object)[], [], 200);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        return mainResponse(false, __('auth.failed'), (object)[], (object)[], [], 401);
    }

    public function logout(Request $request)
    {

        $request->user()->token()->revoke();

//        MobileToken::query()->where('token', $request->token)->delete();
        return mainResponse(true, __('ok'), [], [], [], 200);
    }

    protected function attemptLogin(Request $request)
    {
        return auth()->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );
    }
    protected function credentials(\Illuminate\Http\Request $request)
    {
        //return request()->only($this->username(), 'password');
        return ['email' => $request->{$this->username()}, 'password' => $request->password, 'deleted_at' => null];
    }

    public function username()
    {
        return 'email';
    }

}
