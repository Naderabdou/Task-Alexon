<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;


class ApiAuthController extends Controller
{
    use GeneralTrait;
    public function __construct()
    {
        $this->middleware('AuthApi:user-api', ['except' => ['login', 'register']]);
    }
    public function login(Request $request)
    {
        try {


            $rules = [
                'email' => 'required|email',
                'password' => 'required|min:6',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }


            $credentials = $request->only('email', 'password');
            $token = Auth::guard('user-api')->attempt($credentials);


            if (!$token) {
                return $this->returnError('E001', 'البيانات المدخلة غير صحيحة');
            }

            $user = Auth::user();
            $user->token = $token;
            return $this->returnData('user', $user, 'تم تسجيل الدخول بنجاح');
        } catch (\Exception $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }


    public function register(Request $request) {
        $rules = [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'phone'=>'required|max:100|unique:users',
            'password' => 'required|string|min:6',

        ];
        $validator = Validator::make($request->all(), $rules);


        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }
        $data = $validator->validated();


        $user = User::create(
            [
                'name'=>$data['name'] ,
                'email' =>$data['email'],
                'phone'=>$data['phone'],
                'password'=>Hash::make($data['password']),

            ]
        );
        return $this->returnData('user', $user,'تم التسجيل بنجاح');

    }


    public function logout(Request $request)
    {
        $token = $request -> header('auth-token');

if ($token){
    try {
        JWTAuth::setToken($token)->invalidate();
        return $this->returnSuccessMessage('تم تسجيل الخروج بنجاح');
    }catch (TokenInvalidException $ex){
        return $this->returnError('E001', 'حدث خطأ ما');
    }
}else{
    return $this->returnError('E001','يجب تسجيل الدخول أولا');

}}



    public function refresh()
    {
        return $this->returnData('token', Auth::guard('user-api')->refresh(),'تم تحديث البيانات بنجاح');

    }

}
