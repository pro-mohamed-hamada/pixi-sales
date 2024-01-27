<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\LogoutRequest;
use App\Http\Resources\AuthUserResource;
use App\Models\User;
use App\Services\AuthService;
use Exception;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {
    }

    public function login(LoginRequest $request)
    {
        try {
            
            $remember = isset($request->remember) ? $request->remember:0;
            $user = $this->authService->loginWithEmail(email: $request->email, loginLat: $request->login_lat, loginLng: $request->login_lng, password: $request->password, remember: $remember);
            if(!$user->is_active)
                return apiResponse(message: __('lang.unauthorized'), code: 403);
            return new AuthUserResource($user);
        } catch (Exception|NotFoundException $e) {
            return apiResponse(message: __('lang.phone_or_password_incorrect'), code:442);
        }
    }



    public function authUser(): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $user = Auth::user()->load(['location','attachments']);
            if ($user->type == User::CENTERADMIN)
                $user->load(['center.attachments']);
            return apiResponse(data: new AuthUserResource($user));
        } catch (\Exception $exception) {
            logger('auth user exception');
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    }

    // public function update(UpdateUserRequest $request)//: \Illuminate\Http\RedirectResponse
    // {
    //     try {
    //         $user = auth('sanctum')->user();
    //         $data = $request->validated();
    //         if (!isset($data['password']))
    //             $data = Arr::except($data,'password');
    //         $user = $this->authService->update($user, $data);
    //         return apiResponse(data: new AuthUserResource($user), message: trans('lang.success_operation'));
    //     } catch (\Exception $exception) {
    //         return apiResponse(message: $exception->getMessage(), code: 422);
    //     }
    // }

    public function logout(LogoutRequest $request)
    {

        try {
            $status = $this->authService->logout(logoutLat: $request->logout_lat, logoutLng: $request->logout_lng);
            if($status)
                return apiResponse(message: __('lang.success_operation'), code: 200);
        } catch (Exception $e) {
            return apiResponse(message: $e->getMessage(), code:442);
        }
    }

}
