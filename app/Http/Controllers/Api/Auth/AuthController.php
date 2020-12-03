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
     * @OA\POST(
     *      path="/api/v1/auth/login",
     *      operationId="login",
     *      tags={"Auth"},
     *      summary="login system",
     *      description="You can log in to sytem using this end point",
     *         @OA\RequestBody(
     *         @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *               type="object",
     *               @OA\Property(property="email", type="string"),
     *               @OA\Property(property="password", type="string"),
     *            )
     *        )
     *    ),
     *
     *        @OA\Response(
     *         response="200",
     *         description="Successfull login",
     *     ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Response when username or password is wrong",
     *      ),
     *     )
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
     * @OA\POST(
     *      path="/api/v1/auth/register",
     *      operationId="register",
     *      tags={"Auth"},
     *      summary="register a user to system",
     *      description="You can use  this end  point to save  a user to sytem.",
     *         @OA\RequestBody(
     *         @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *               type="object",
     *               @OA\Property(property="name", type="string"),
     *               @OA\Property(property="surname", type="string"),
     *               @OA\Property(property="email", type="string"),
     *               @OA\Property(property="password", type="string"),
     *               @OA\Property(property="phone_number", type="string"),
     *               @OA\Property(property="twitter", type="string"),
     *            )
     *        )
     *    ),
     *        @OA\Response(
     *         response="200",
     *         description="Successfull register",
     *     ),
     *      @OA\Response(
     *          response=400,
     *          description="If a required fied is null, it shows Bad Reponse",
     *      ),
     *     )
     */
    public function register(UserStore $request, AuthService $authService)
    {

        $user = $authService->register($request);

        return $this->service->success(new UserResource($user), Response::HTTP_CREATED);
    }



    /**
     * @OA\POST(
     *      path="/api/v1/auth/verify",
     *      operationId="veriyf",
     *      tags={"Auth"},
     *      summary="verify a user",
     *      description="You can verify a user using this end  point.",
     *         @OA\RequestBody(
     *         @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *               type="object",
     *               @OA\Property(property="email", type="string"),
     *               @OA\Property(property="code", type="string"),
     *            )
     *        )
     *    ),
     *        @OA\Response(
     *         response="200",
     *         description="Verify user successfull",
     *     ),
     *      @OA\Response(
     *          response=400,
     *          description="If a required fied is null, it shows Bad Reponse",
     *      ),
     *     )
     */
    public function verify(UserVerify $request, AuthService $authService)
    {
        $authService->verify($request);
        return $this->service->success();
    }



    /**
     * @OA\GET(
     *      path="/api/v1/auth/me",
     *      operationId="me",
     *      tags={"Auth"},
     *      summary="show about logged user",
     *      description="You can give about information logged user using this end point",
     *        @OA\Response(
     *         response="200",
     *         description="Verify user successfull",
     *     ),
             @OA\Response(
     *          response=403,
     *          description="Forbidden error ",
     *      ),
     *      security={{ "apiAuth": {} }}
     *     )
     */
    public function me(Request $request)
    {
        return $this->service->success(new UserResource($request->user()));
    }
}
