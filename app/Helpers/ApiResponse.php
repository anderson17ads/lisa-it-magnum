<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    /**
     * Returns a success response.
     *
     * This method returns a standardized success response with a message and data.
     *
     * @param mixed $data Data to be returned.
     * @param string $message Custom message.
     * @param int $status HTTP status code (default is 200).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public static function success(
        mixed $data = null, 
        string $message = 'Request successful', 
        int $status = JsonResponse::HTTP_OK
    ): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    /**
     * Returns an error response.
     *
     * This method returns a standardized error response with a message and null data.
     *
     * @param mixed $data Data to be returned.
     * @param string $message Error message.
     * @param int $status HTTP status code (default is 400).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public static function error(
        mixed $data = null,
        string $message, 
        int $status = JsonResponse::HTTP_BAD_REQUEST
    ): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    /**
     * Returns a created response.
     *
     * This method returns a success response with the data of the created resource.
     *
     * @param mixed $data Data of the created resource.
     * @param string $message Custom message (default is "Resource created successfully").
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public static function created(
        mixed $data, 
        string $message = 'Resource created successfully'
    ): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], JsonResponse::HTTP_CREATED);
    }
}
