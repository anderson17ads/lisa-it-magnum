<?php

namespace App\Swagger;

class AuthSwagger
{
    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="User login",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="teste@lisait.com.br"),
     *             @OA\Property(property="password", type="string", format="password", example="123456")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Login successful"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="access_token", type="string", example="jwt_token"),
     *                 @OA\Property(property="token_type", type="string", example="bearer"),
     *                 @OA\Property(property="expires_in", type="integer", example=3600)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Validation error"),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(property="email", type="array", 
     *                      @OA\Items(type="string", example={
     *                          "The field email is required.", 
     *                          "The email is invalid."
     *                      })
     *                 ),
     *                 @OA\Property(property="password", type="array", 
     *                      @OA\Items(type="string", example={
     *                          "The field password is required.",
     *                          "The password must have at least 6 digits."
     *                      })
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized access",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Unauthorized access. Please check your credentials or token."
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="null",
     *                 example=null
     *             )
     *         )
     *     )
     * )
     */
    public function login()
    {
        //
    }

    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Register a new user",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password"},
     *             @OA\Property(property="name", type="string", example="Anderson de Souza"),
     *             @OA\Property(property="email", type="string", format="email", example="anderson17ads@hotmail.com"),
     *             @OA\Property(property="password", type="string", format="password", example="123456")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User successfully registered",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User successfully registered"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Anderson de Souza"),
     *                 @OA\Property(property="email", type="string", example="anderson17ads@hotmail.com")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Validation error"),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(property="name", type="array", 
     *                      @OA\Items(type="string", example={
     *                          "The name field is required.",
     *                          "The field name is invalid."
     *                      })
     *                 ),
     *                 @OA\Property(property="email", type="array", 
     *                      @OA\Items(type="string", example={
     *                          "The field email is required.", 
     *                          "The email is invalid.", 
     *                          "This email is already in use."
     *                      })
     *                 ),
     *                 @OA\Property(property="password", type="array", 
     *                      @OA\Items(type="string", example={
     *                          "The field password is required.",
     *                          "The password must have at least 6 digits."
     *                      })
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function register()
    {
        //
    }
}