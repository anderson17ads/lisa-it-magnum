<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Services\UserService;
use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthController extends Controller
{
    /**
     * @var UserService The service responsible for user-related operations.
     */
    private $userService;

    /**
     * AuthController constructor.
     *
     * @param UserService $userService The service layer for user management.
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Handle user login and generate a JWT token.
     *
     * @param AuthLoginRequest $request The validated login request containing email and password.
     * 
     * @throws UnauthorizedHttpException If the credentials are invalid.
     * 
     * @return \Illuminate\Http\JsonResponse The response containing the JWT token and related data.
     */
    public function login(AuthLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            throw new UnauthorizedHttpException('');
        }

        return $this->responseWithToken($token);
    }

    /**
     * Handle user registration and generate a JWT token.
     *
     * @param AuthRegisterRequest $request The validated registration request containing user details.
     * 
     * @return \Illuminate\Http\JsonResponse The response containing the JWT token and related data.
     */
    public function register(AuthRegisterRequest $request)
    {
        $user = $this->userService->register([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return $this->responseWithToken(
            JWTAuth::fromUser($user),
            'User successfully registered'
        );
    }

    /**
     * Generate a success response with the given JWT token.
     *
     * @param string $token The JWT token to include in the response.
     * 
     * @return \Illuminate\Http\JsonResponse The response containing the token, its type, and expiration time.
     */
    protected function responseWithToken(string $token, string $message = 'Login successful')
    {
        return ApiResponse::success(
            [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => JWTAuth::factory()->getTTL() * 60
            ],
            $message
        );
    } 
}
