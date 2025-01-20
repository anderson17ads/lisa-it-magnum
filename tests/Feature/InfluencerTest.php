<?php

namespace Tests\Feature;

use App\Models\Campaign;
use App\Models\Influencer;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Illuminate\Support\Str;
use Illuminate\Contracts\Auth\Authenticatable;
use Tests\TestCase;

class InfluencerTest extends TestCase
{
    use RefreshDatabase;

    private const DEFAULT_DATA = [
        'user' => [
            'email' => 'teste@lisait.com.br',
            'password' => '123456',
        ],
    ];

    private Authenticatable $user;

    private int $categoryId;

    protected function setUp(): void
    {
        parent::setUp();

        // Create user
        $this->user = User::factory()->create([
            'email' => self::DEFAULT_DATA['user']['email'],
            'password' => bcrypt(self::DEFAULT_DATA['user']['password']),
        ]);

        // Create category id
        $this->categoryId = Category::factory()->create()->id;
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
            $data = array_merge(
                $dataProvider['data'],
                ['category_id' => $this->categoryId],
            );

            Influencer::factory()->create($data);
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
            ->getJson('/api/influencers');

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

        $data = array_merge(
            $dataProvider['data'],
            ['category_id' => $dataProvider['data']['category_id'] ?? $this->categoryId],
        );

        // Create influencer for validate unique register
        if (in_array('unique', $dataProvider['context'])) {
            Influencer::factory()->create($data);
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
            ->postJson('/api/influencers', $data);

        $response
            ->assertStatus($dataProvider['status'])
            ->assertJsonStructure($dataProvider['expectedStructure'])
            ->assertJsonFragment(['message' => $dataProvider['message']]);

        $this->handleValidate($response, $dataProvider);
    }

    /**
     * 
     * @dataProvider campaignStoreDataProvider
     */
    public function test_campaign_store(...$dataProvider)
    {
        $dataProvider = $dataProvider[0];
        $contextUnauthorized = in_array('unauthorized', $dataProvider['context']);
        $influencer = Influencer::factory()->create(['category_id' => $this->categoryId]);
        $campaign = Campaign::factory()->create();

        $influencerId = $dataProvider['data']['influencerId'] ?? $influencer->id;
        $campaignId = $dataProvider['data']['campaignId'] ?? $campaign->id;

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
            ->postJson("/api/influencers/{$influencerId}/campaigns", [
                'campaigns' => [$campaignId]
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
        $contextValidation = in_array('validation', $dataProvider['context']);
        $contextCreate = in_array('create', $dataProvider['context']);

        $typeStore = $dataProvider['type'] == 'store';

        // Validate only context validation
        if ($contextValidation) {
            $response->assertJsonFragment(['errors' => $dataProvider['errors']]);
        }

        // Validate type create
        if ($typeStore) {
            // Validate context create
            if ($contextCreate) {
                $this->assertDatabaseHas('influencers', [
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
                'data' => [],
                'status' => JsonResponse::HTTP_OK,
                'message' => 'List of influencers',
                'expectedStructure' => [
                    'message',
                    'data',            
                ],
            ]],
            'With no items' => [[
                'type' => 'index',
                'context' => ['no_items'],
                'data' => [],
                'status' => JsonResponse::HTTP_OK,
                'message' => 'List of influencers',
                'expectedStructure' => [
                    'message',
                    'data',            
                ],
            ]],
            'With invalid credentials' => [[
                'type' => 'index',
                'context' => ['unauthorized', 'no_items'],
                'data' => [],
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
            'with influencer created' => [[
                'type' => 'store',
                'context' => ['create'],
                'data' => [
                    'name' => 'Anderson de Souza',
                    'instagram_user' => 'anderson17ads',
                    'instagram_followers_count' => 45,
                ],
                'status' => JsonResponse::HTTP_CREATED,
                'message' => 'Influencer created successfully',
                'expectedStructure' => [
                    'message',
                    'data' => [
                        'id',
                        'name',
                        'instagram_user',
                        'instagram_followers_count',
                        'category' => [
                            'id',
                            'name',
                        ],
                    ],              
                ],
            ]],
            'With validate required name' => [[
                'type' => 'store',
                'context' => ['validation'],
                'data' => [
                    'name' => '',
                    'instagram_user' => 'anderson17ads',
                    'instagram_followers_count' => 45,
                ],
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
                'data' => [
                    'name' => 123,
                    'instagram_user' => 'anderson17ads',
                    'instagram_followers_count' => 45,
                ],
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
                'data' => [
                    'name' => Str::random(46),
                    'instagram_user' => 'anderson17ads',
                    'instagram_followers_count' => 45,
                ],
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => 'Validation Error',
                'expectedStructure' => [
                    'data' => ['errors' => ['name']],
                ],
                'errors' => [
                    'name' => ['The maximum character limit is 45.'],
                ],
            ]],
            'With validate required instagram_user' => [[
                'type' => 'store',
                'context' => ['validation'],
                'data' => [
                    'name' => 'Anderson de Souza',
                    'instagram_user' => '',
                    'instagram_followers_count' => 45,
                ],
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => 'Validation Error',
                'expectedStructure' => [
                    'data' => ['errors' => ['instagram_user']],
                ],
                'errors' => [
                    'instagram_user' => ['Instagram username is required.'],
                ],
            ]],
            'With invalid instagram_user' => [[
                'type' => 'store',
                'context' => ['validation'],
                'data' => [
                    'name' => 'Anderson de Souza',
                    'instagram_user' => 123,
                    'instagram_followers_count' => 45,
                ],
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => 'Validation Error',
                'expectedStructure' => [
                    'data' => ['errors' => ['instagram_user']],
                ],
                'errors' => [
                    'instagram_user' => ['Instagram username is invalid.'],
                ],
            ]],
            'With validate max string instagram_user' => [[
                'type' => 'store',
                'context' => ['validation'],
                'data' => [
                    'name' => 'Anderson de Souza',
                    'instagram_user' => Str::random(46),
                    'instagram_followers_count' => 45,
                ],
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => 'Validation Error',
                'expectedStructure' => [
                    'data' => ['errors' => ['instagram_user']],
                ],
                'errors' => [
                    'instagram_user' => ['The maximum character limit is 45.'],
                ],
            ]],
            'With validate unique instagram_user' => [[
                'type' => 'store',
                'context' => ['validation', 'unique'],
                'data' => [
                    'name' => 'Anderson de Souza',
                    'instagram_user' => Str::random(46),
                    'instagram_followers_count' => 45,
                ],
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => 'Validation Error',
                'expectedStructure' => [
                    'data' => ['errors' => ['instagram_user']],
                ],
                'errors' => [
                    'instagram_user' => ['The maximum character limit is 45.'],
                ],
            ]],
            'With validate required instagram_followers_count' => [[
                'type' => 'store',
                'context' => ['validation'],
                'data' => [
                    'name' => 'Anderson de Souza',
                    'instagram_user' => 'anderson17ads',
                    'instagram_followers_count' => '',
                ],
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => 'Validation Error',
                'expectedStructure' => [
                    'data' => ['errors' => ['instagram_followers_count']],
                ],
                'errors' => [
                    'instagram_followers_count' => ['The followers number field is required.'],
                ],
            ]],
            'With validate required category_id' => [[
                'type' => 'store',
                'context' => ['validation'],
                'data' => [
                    'name' => 'Anderson de Souza',
                    'instagram_user' => 'anderson17ads',
                    'instagram_followers_count' => 45,
                    'category_id' => ''
                ],
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => 'Validation Error',
                'expectedStructure' => [
                    'data' => ['errors' => ['category_id']],
                ],
                'errors' => [
                    'category_id' => ['The category field is required.'],
                ],
            ]],
            'With invalid category_id' => [[
                'type' => 'store',
                'context' => ['validation'],
                'data' => [
                    'name' => 'Anderson de Souza',
                    'instagram_user' => 'anderson17ads',
                    'instagram_followers_count' => 45,
                    'category_id' => 'addasdas'
                ],
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => 'Validation Error',
                'expectedStructure' => [
                    'data' => ['errors' => ['category_id']],
                ],
                'errors' => [
                    'category_id' => ['This category is invalid.'],
                ],
            ]],
        ];
    }

    public static function campaignStoreDataProvider(): array
    {
        return [
            'with campaign created' => [[
                'type' => 'campaignStore',
                'context' => ['create'],
                'data' => [],
                'status' => JsonResponse::HTTP_CREATED,
                'message' => 'Campaigns created successfully',
                'expectedStructure' => [
                    'message',
                    'data' => [
                        'id',
                        'name',
                        'instagram_user',
                        'instagram_followers_count',
                        'category' => [
                            'id',
                            'name',
                        ],
                    ],              
                ],
            ]],
            'with influencer not existing' => [[
                'type' => 'campaignStore',
                'context' => ['create'],
                'data' => [
                    'influencerId' => fake()->numberBetween(0, 1000),
                ],
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => 'Validation Error',
                'expectedStructure' => [
                    'data' => ['errors' => ['id']],
                ],
                'errors' => [
                    'id' => ['The influencer does not exist.'],
                ],
            ]],
            'with campaign not existing' => [[
                'type' => 'campaignStore',
                'context' => ['create'],
                'data' => [
                    'campaignId' => fake()->numberBetween(0, 1000),
                ],
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => 'Validation Error',
                'expectedStructure' => [
                    'data' => ['errors' => ['campaigns']],
                ],
                'errors' => [
                    'campaigns' => ['Campaign 999 does not exist.'],
                ],
            ]],
        ];
    }
}
