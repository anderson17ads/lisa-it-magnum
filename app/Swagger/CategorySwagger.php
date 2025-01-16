<?php

namespace App\Swagger;

class CategorySwagger
{
    /**
     * @OA\Get(
     *     path="/api/categories",
     *     summary="List of categories",
     *     tags={"Categories"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of categories",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="List of categories"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example="1"),
     *                 @OA\Property(property="name", type="string", example="Beleza"),
     *                 @OA\Property(
     *                      property="influencers",
     *                      type="array",
     *                      @OA\Items(
     *                          @OA\Property(property="id", type="integer", example=15),
     *                          @OA\Property(property="name", type="string", example="Anderson de Souza"),
     *                          @OA\Property(property="instagram_user", type="string", example="anderson17ads"),
     *                          @OA\Property(property="instagram_followers_count", type="integer", example=45),
     *                          @OA\Property(
     *                              property="category",
     *                              type="object",
     *                              @OA\Property(property="id", type="integer", example=2),
     *                              @OA\Property(property="name", type="string", example="Beleza")
     *                          )
     *                      )
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
    public function index()
    {
        //
    }

    /**
     * @OA\Schema(
     *     schema="Category - Create a new Category",
     *     required={"name"},
     *     @OA\Property(property="name", type="string", example="Beleza")
     * ),
     * @OA\Post(
     *     path="/api/categories",
     *     summary="Create a new category",
     *     tags={"Categories"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Beleza")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Category created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Category created successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="number", example=1),
     *                 @OA\Property(property="name", type="string", example="Beleza")
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
     *                          "This name is invalid.",
     *                          "The maximum character limit is 45"
     *                      })
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function store()
    {
        // 
    }
}