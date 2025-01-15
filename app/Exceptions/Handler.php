<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;
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

    public function render($request, Throwable $exception)
    {
        // ValidationException
        if ($exception instanceof ValidationException) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $exception->errors(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Exception
        if ($exception instanceof Exception) {
            return response()->json([
                'message' => 'An internal error has occurred',
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        // ApiException
        if ($exception instanceof ApiException) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

        return parent::render($request, $exception);
    }
}
