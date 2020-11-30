<?php

namespace App\Http\Middleware;

use App\Services\Utility\JsonResponseService;
use Closure;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class ApiTokenCheck
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $user = User::where('api_token', '=', $this->getToken())->first();
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        if (!$request->user()) {
            throw new HttpResponseException(
                (new JsonResponseService())->forbidden());
        }
        return $next($request);
    }


    /**
     * @return string
     */
    private function getToken(): string
    {
        return Auth::guard('api')->getTokenForRequest() ?? '';
    }
}
