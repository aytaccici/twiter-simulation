<?php

namespace App\Exceptions;

use App\Http\Controllers\BaseApiController;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];


    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    protected $baseApiController;

    public function __construct(Container $container, BaseApiController $baseApiController)
    {
        $this->baseApiController = $baseApiController;
        parent::__construct($container);
    }

    /**
     * Report or log an exception.
     *
     * @param \Exception $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof MethodNotAllowedHttpException) {

            return $this->baseApiController->service->fail(Response::HTTP_METHOD_NOT_ALLOWED, $exception->getMessage());
        }


        if ($exception instanceof AuthenticationException) {
            return $this->baseApiController->service->fail(Response::HTTP_UNAUTHORIZED, $exception->getMessage());
        }

        if ($exception instanceof ModelNotFoundException) {

            return $this->baseApiController->service->fail(Response::HTTP_NOT_FOUND, $exception->getMessage());
        }

        if ($exception instanceof NotFoundHttpException) {

            return $this->baseApiController->service->fail(Response::HTTP_NOT_FOUND, $exception->getMessage());
        }

        if ($exception instanceof AuthorizationException) {

            return $this->baseApiController->service->fail(Response::HTTP_UNAUTHORIZED, $exception->getMessage());
        }


        if ($exception instanceof HttpResponseException) {
            return parent::render($request, $exception);
        }

        return parent::render($request, $exception);
    }
}
