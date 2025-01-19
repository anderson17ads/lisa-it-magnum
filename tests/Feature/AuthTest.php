<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Illuminate\Support\Str;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    private const DEFAULT_DATA = [
        'name' => 'Test Lisa',
        'email' => 'teste@lisait.com.br',
        'password' => '123456',
        'passwordInvalid' => '654321',
    ];

    /**
     * 
     * @dataProvider loginDataProvider
     */
    public function test_login(...$dataProvider)
    {
        $dataProvider = $dataProvider[0];

        $data = [
            'email' => $dataProvider['email'],
            'password' => $dataProvider['password'],
        ];

        User::factory()->create([
            'email' => self::DEFAULT_DATA['email'],
            'password' => bcrypt(self::DEFAULT_DATA['password']),
        ]);

        $response = $this->postJson('/api/login', $data);
        $response
            ->assertStatus($dataProvider['status'])
            ->assertJsonStructure($dataProvider['expectedStructure'])
            ->assertJsonFragment(['message' => $dataProvider['message']]);

        $this->handleValidate($response, $dataProvider);
    }

    /**
     * 
     * @dataProvider registerDataProvider
     */
    public function test_register(...$dataProvider)
    {
        $dataProvider = $dataProvider[0];

        // Create user for validate unique register
        if (in_array('unique', $dataProvider['context'])) {
            User::factory()->create([
                'email' => $dataProvider['email'],
                'password' => bcrypt($dataProvider['password']),
            ]);
        }

        $response = $this->postJson('/api/register', [
            'name' => $dataProvider['name'],
            'email' => $dataProvider['email'],
            'password' => $dataProvider['password'],
        ]);

        $response
            ->assertStatus($dataProvider['status'])
            ->assertJsonStructure($dataProvider['expectedStructure'])
            ->assertJsonFragment(['message' => $dataProvider['message']]);

        $this->handleValidate($response, $dataProvider);
    }

    /**
     * Handle validate
     * 
     * @param TestResponse $response
     * @param array $dataProvider
     * 
     * @return void
     */
    private function handleValidate(
        TestResponse $response, 
        array $dataProvider
    ): void
    {
        $data = $response->json()['data'] ?? null;
        
        $contextSuccess = in_array('success', $dataProvider['context']);
        $contextValidation = in_array('validation', $dataProvider['context']);
        $contextCreate = in_array('create', $dataProvider['context']);

        $typeRegister = $dataProvider['type'] == 'register';

        // Validate only context success
        if ($contextSuccess) {
            $this->assertNotEmpty($data['access_token']);
        }

        // Validate only context validation
        if ($contextValidation) {
            $response->assertJsonFragment(['errors' => $dataProvider['errors']]);
        }

        // Validate type register
        if ($typeRegister) {
            // Validate context create
            if ($contextCreate) {
                $this->assertDatabaseHas('users', [
                    'email' => $dataProvider['email'],
                ]);
            }
        }
    }
    
    public static function loginDataProvider(): array
    {
        return [
            'With valid credentials' => [[
                'type' => 'login',
                'context' => ['success'],
                'email' => self::DEFAULT_DATA['email'],
                'password' => self::DEFAULT_DATA['password'],
                'status' => JsonResponse::HTTP_OK,
                'message' => 'Login successful',
                'expectedStructure' => [
                    'message',
                    'data' => [
                        'access_token',
                        'token_type',
                        'expires_in',
                    ],              
                ],
            ]],
            'With invalid credentials' => [[
                'type' => 'login',
                'context' => ['unauthorized'],
                'email' => self::DEFAULT_DATA['email'],
                'password' => self::DEFAULT_DATA['passwordInvalid'],
                'status' => JsonResponse::HTTP_UNAUTHORIZED,
                'message' => 'Unauthorized access. Please check your credentials or token.',
                'expectedStructure' => [
                    'message',
                    'data',
                ],
            ]],
            'With invalid email format' => [[
                'type' => 'login',
                'context' => ['validation'],
                'email' => 'test',
                'password' => self::DEFAULT_DATA['password'],
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => 'Validation Error',
                'expectedStructure' => [
                    'data' => ['errors' => ['email']],
                ],
                'errors' => [
                    'email' => ['The field email is invalid.'],
                ],
            ]],
            'With invalid password format' => [[
                'type' => 'login',
                'context' => ['validation'],
                'email' => self::DEFAULT_DATA['email'],
                'password' => '123',
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => 'Validation Error',
                'expectedStructure' => [
                    'data' => ['errors' => ['password']],
                ],
                'errors' => [
                    'password' => ['The password must have at least 6 digits.'],
                ],
            ]],
            'With invalid email and password format' => [[
                'type' => 'login',
                'context' => ['validation'],
                'email' => 'test',
                'password' => '123',
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => 'Validation Error',
                'expectedStructure' => [
                    'data' => ['errors' => ['email', 'password']],
                ],
                'errors' => [
                    'email' => ['The field email is invalid.'],
                    'password' => ['The password must have at least 6 digits.'],
                ],
            ]],
        ];
    }

    public static function registerDataProvider(): array
    {
        return [
            'With valid data' => [[
                'type' => 'register',
                'context' => ['create'],
                'name' => self::DEFAULT_DATA['name'],
                'email' => self::DEFAULT_DATA['email'],
                'password' => self::DEFAULT_DATA['password'],
                'status' => JsonResponse::HTTP_OK,
                'message' => 'User successfully registered',
                'expectedStructure' => [
                    'message',
                    'data' => [
                        'access_token',
                        'token_type',
                        'expires_in',
                    ],              
                ],
            ]],
            'With validate required name' => [[
                'type' => 'register',
                'context' => ['validation'],
                'name' => '',
                'email' => self::DEFAULT_DATA['email'],
                'password' => self::DEFAULT_DATA['password'],
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => 'Validation Error',
                'expectedStructure' => [
                    'data' => ['errors' => ['name']],
                ],
                'errors' => [
                    'name' => ['The field name is required.'],
                ],
            ]],
            'With invalid name' => [[
                'type' => 'register',
                'context' => ['validation'],
                'name' => 123,
                'email' => self::DEFAULT_DATA['email'],
                'password' => self::DEFAULT_DATA['password'],
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => 'Validation Error',
                'expectedStructure' => [
                    'data' => ['errors' => ['name']],
                ],
                'errors' => [
                    'name' => ['The field name is invalid.'],
                ],
            ]],
            'With validate max string name' => [[
                'type' => 'register',
                'context' => ['validation'],
                'name' => Str::random(256),
                'email' => self::DEFAULT_DATA['email'],
                'password' => self::DEFAULT_DATA['password'],
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => 'Validation Error',
                'expectedStructure' => [
                    'data' => ['errors' => ['name']],
                ],
                'errors' => [
                    'name' => ['The maximum character limit is 255.'],
                ],
            ]],
            'With validate required email' => [[
                'type' => 'register',
                'context' => ['validation'],
                'name' => self::DEFAULT_DATA['name'],
                'email' => '',
                'password' => self::DEFAULT_DATA['password'],
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => 'Validation Error',
                'expectedStructure' => [
                    'data' => ['errors' => ['email']],
                ],
                'errors' => [
                    'email' => ['The field email is required.'],
                ],
            ]],
            'With invalid email' => [[
                'type' => 'register',
                'context' => ['validation'],
                'name' => self::DEFAULT_DATA['email'],
                'email' => 'das',
                'password' => self::DEFAULT_DATA['password'],
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => 'Validation Error',
                'expectedStructure' => [
                    'data' => ['errors' => ['email']],
                ],
                'errors' => [
                    'email' => ['The field email is invalid.'],
                ],
            ]],
            'With validate unique email' => [[
                'type' => 'register',
                'context' => ['validation', 'unique'],
                'name' => self::DEFAULT_DATA['name'],
                'email' => self::DEFAULT_DATA['email'],
                'password' => self::DEFAULT_DATA['password'],
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => 'Validation Error',
                'expectedStructure' => [
                    'data' => ['errors' => ['email']],
                ],
                'errors' => [
                    'email' => ['This field email is already in use.'],
                ],
            ]],
            'With validate required password' => [[
                'type' => 'register',
                'context' => ['validation'],
                'name' => self::DEFAULT_DATA['name'],
                'email' => self::DEFAULT_DATA['email'],
                'password' => '',
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => 'Validation Error',
                'expectedStructure' => [
                    'data' => ['errors' => ['password']],
                ],
                'errors' => [
                    'password' => ['The field password is required.'],
                ],
            ]],
            'With validate min password' => [[
                'type' => 'register',
                'context' => ['validation'],
                'name' => self::DEFAULT_DATA['name'],
                'email' => self::DEFAULT_DATA['email'],
                'password' => Str::random(5),
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => 'Validation Error',
                'expectedStructure' => [
                    'data' => ['errors' => ['password']],
                ],
                'errors' => [
                    'password' => ['The password must have at least 6 digits.'],
                ],
            ]],
        ];
    }
}
