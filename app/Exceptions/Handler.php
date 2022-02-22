<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
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
        $this->renderable(function (NotFoundHttpException $e) {
            //
            return response()->json(["message" => __('messages.not_found')], HttpFoundationResponse::HTTP_NOT_FOUND);
        });
        $this->renderable(function (AuthenticationException $e) {
            //
            return response()->json(["message" => __('messages.unathorized')], HttpFoundationResponse::HTTP_UNAUTHORIZED);
        });
        $this->renderable(function (MethodNotAllowedHttpException $e) {
            //
            return response()->json(["message" => 'method not allowed'], HttpFoundationResponse::HTTP_METHOD_NOT_ALLOWED);
        });
    }
}
