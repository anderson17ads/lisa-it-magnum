<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    private const DEFAULT_DATA = [
        'name' => 'Beleza',
        'user' => [
            'email' => 'teste@lisait.com.br',
            'password' => '123456',
        ],
    ];

    private Authenticatable $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'email' => self::DEFAULT_DATA['user']['email'],
            'password' => bcrypt(self::DEFAULT_DATA['user']['password']),
        ]);
    }

    /**
     * 
     * @dataProvider indexDataProvider
     */
    public function test_index(...$dataProvider)
    {
        $dataProvider = $dataProvider[0];
        $contextNoItems = in_array('no_items', $dataProvider['context']);
        $contextUnauthorized = in_array('unauthorized', $dataProvider['context']);

        if (!$contextNoItems) {
            Category::factory()->create($dataProvider['data']);
        }

        $token = auth('api')->login($this->user);

        if ($contextUnauthorized) {
            $token = auth('api')->attempt([
                'email' => fake()->unique()->safeEmail(),
                'password' => Str::random(6),
            ]);
        }

        $response = $this
            ->withHeaders([
                'Authorization' => "Bearer {$token}",
            ])
            ->getJson('/api/categories');

        $response
            ->assertStatus($dataProvider['status'])
            ->assertJsonStructure($dataProvider['expectedStructure'])
            ->assertJsonFragment(['message' => $dataProvider['message']]);

        $this->handleValidate($response, $dataProvider);
    }

    /**
     * 
     * @dataProvider storeDataProvider
     */
    public function test_store(...$dataProvider)
    {
        $dataProvider = $dataProvider[0];
        $contextUnauthorized = in_array('unauthorized', $dataProvider['context']);

        // Create user for validate unique register
        if (in_array('unique', $dataProvider['context'])) {
            Category::factory()->create($dataProvider['data']);
        }

        $token = auth('api')->login($this->user);

        if ($contextUnauthorized) {
            $token = auth('api')->attempt([
                'email' => fake()->unique()->safeEmail(),
                'password' => Str::random(6),
            ]);
        }

        $response = $this
            ->withHeaders([
                'Authorization' => "Bearer {$token}",
            ])
            ->postJson('/api/categories', $dataProvider['data']);

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
        $contextValidation = in_array('validation', $dataProvider['context']);
        $contextCreate = in_array('create', $dataProvider['context']);

        $typeCreate = $dataProvider['type'] == 'store';

        // Validate only context validation
        if ($contextValidation) {
            $response->assertJsonFragment(['errors' => $dataProvider['errors']]);
        }

        // Validate type create
        if ($typeCreate) {
            // Validate context create
            if ($contextCreate) {
                $this->assertDatabaseHas('categories', [
                    'name' => $dataProvider['data']['name'],
                ]);
            }
        }
    }
    
    public static function indexDataProvider(): array
    {
        return [
            'With items' => [[
                'type' => 'index',
                'context' => [],
                'data' => ['name' => self::DEFAULT_DATA['name']],
                'status' => JsonResponse::HTTP_OK,
                'message' => 'List of categories',
                'expectedStructure' => [
                    'message',
                    'data',            
                ],
            ]],
            'With no items' => [[
                'type' => 'index',
                'context' => ['no_items'],
                'data' => [self::DEFAULT_DATA['name']],
                'status' => JsonResponse::HTTP_OK,
                'message' => 'List of categories',
                'expectedStructure' => [
                    'message',
                    'data',            
                ],
            ]],
            'With invalid credentials' => [[
                'type' => 'index',
                'context' => ['unauthorized', 'no_items'],
                'data' => [self::DEFAULT_DATA['name']],
                'user' => [
                    'email' => fake()->unique()->safeEmail(),
                    'password' => Str::random(6),
                ],
                'status' => JsonResponse::HTTP_UNAUTHORIZED,
                'message' => 'Unauthorized access. Please check your credentials or token.',
                'expectedStructure' => [
                    'message',
                    'data',            
                ],
            ]],
        ];
    }

    public static function storeDataProvider(): array
    {
        return [
            'with category created' => [[
                'type' => 'store',
                'context' => ['create'],
                'data' => ['name' => self::DEFAULT_DATA['name']],
                'status' => JsonResponse::HTTP_CREATED,
                'message' => 'Category created successfully',
                'expectedStructure' => [
                    'message',
                    'data' => [
                        'id',
                        'name',
                    ],              
                ],
            ]],
            'With validate required name' => [[
                'type' => 'store',
                'context' => ['validation'],
                'data' => ['name' => ''],
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => 'Validation Error',
                'expectedStructure' => [
                    'data' => ['errors' => ['name']],
                ],
                'errors' => [
                    'name' => ['The name field is required.'],
                ],
            ]],
            'With invalid name' => [[
                'type' => 'store',
                'context' => ['validation'],
                'data' => ['name' => 123],
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => 'Validation Error',
                'expectedStructure' => [
                    'data' => ['errors' => ['name']],
                ],
                'errors' => [
                    'name' => ['The name field is invalid.'],
                ],
            ]],
            'With validate max string name' => [[
                'type' => 'store',
                'context' => ['validation'],
                'data' => ['name' => Str::random(46)],
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => 'Validation Error',
                'expectedStructure' => [
                    'data' => ['errors' => ['name']],
                ],
                'errors' => [
                    'name' => ['The maximum character limit is 45.'],
                ],
            ]],           
        ];
    }
}
