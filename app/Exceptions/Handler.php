<?php

namespace App\Exceptions;

use App\Helpers\ApiResponse;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontReport = [
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $exception
     *
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Throwable $exception)
    {
        // UnauthorizedHttpException
        if ($exception instanceof UnauthorizedHttpException) {
            return ApiResponse::error(
                null,
                'Unauthorized access. Please check your credentials or token.',
                JsonResponse::HTTP_UNAUTHORIZED
            );
        }

        // ValidationException
        if ($exception instanceof ValidationException) {
            return ApiResponse::error(
                ['errors' => $exception->errors()],
                'Validation Error',
                JsonResponse::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        // Exception
        if ($exception instanceof Exception) {
            return ApiResponse::error(
                null,
                'An internal error has occurred',
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        // ApiException
        if ($exception instanceof ApiException) {
            return ApiResponse::error(
                null,
                $exception->getMessage(),
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        return parent::render($request, $exception);
    }
}
