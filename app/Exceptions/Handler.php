<?php

namespace App\Exceptions;

use Exception;
use GuzzleHttp\Exception\ServerException;
use HttpException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->expectsJson()) {
                return api_exception($e);
            }
        });
        $this->renderable(function (AuthorizationException $e, $request) {
            if ($request->expectsJson()) {
                return api_exception($e);
            }
        });
        $this->renderable(function (ServerException $e, $request) {
            if ($request->expectsJson()) {
                return api_exception($e);
            }
        });
        $this->renderable(function (ModelNotFoundException $e, $request) {

            if ($request->expectsJson()) {
                return api_exception($e);
            }
        });
        $this->renderable(function (RouteNotFoundException $e, $request) {
            if ($request->expectsJson()) {
                return api_exception($e);
            }
        });
        $this->renderable(function (HttpException $e, $request) {
            if ($request->expectsJson()) {
                return api_exception($e);
            }
        });
        $this->renderable(function (MethodNotAllowedHttpException $e, $request) {
            if ($request->expectsJson()) {
                return api_exception($e);
            }
        });
        $this->renderable(function (Exception $e, $request) {
            if ($request->expectsJson()) {
                return api_exception($e);
            }
        });
    }
}
