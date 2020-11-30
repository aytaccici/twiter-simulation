<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\BaseApiController;
use App\Http\Requests\Auth\Login;
use App\Http\Requests\Auth\UserStore;
use App\Http\Requests\Auth\UserVerify;
use App\Http\Resources\User\UserResource as UserResource;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends BaseApiController
{

    /**
     * @param Login $request
     * @param AuthService $authService
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Login $request, AuthService $authService)
    {

        $credentials = $request->only('email', 'password');

        if (!$authService->authenticate($credentials)) {
            return $this->service->fail(Response::HTTP_BAD_REQUEST, 'Invalid credentials');
        }

        $authService->updateAccessToken($request->user());

        return $this->service->success(new UserResource($request->user()));
    }


    /**
     * @param UserStore $request
     * @param AuthService $authService
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(UserStore $request, AuthService $authService)
    {

        $user = $authService->register($request);

        return $this->service->success(new UserResource($user), Response::HTTP_CREATED);
    }


    /**
     * @param UserStore $request
     * @param AuthService $authService
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(UserVerify $request, AuthService $authService)
    {
        $authService->verify($request);
        return $this->service->success();
    }


    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request)
    {
        return $this->service->success(new UserResource($request->user()));
    }
}
