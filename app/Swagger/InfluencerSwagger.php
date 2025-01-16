<?php

namespace App\Swagger;

class InfluencerSwagger
{
    /**
     * @OA\Get(
     *     path="/api/influencers",
     *     summary="List of influencers",
     *     tags={"Influencers"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of influencers",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="List of influencers"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example="1"),
     *                 @OA\Property(property="name", type="string", example="Anderson de Souza"),
     *                 @OA\Property(property="instagram_user", type="string", example="anderson17ads"),
     *                 @OA\Property(property="instagram_followers_count", type="number", example=45),
     *                 @OA\Property(
     *                      property="category", 
     *                      type="object", 
     *                      @OA\Property(property="id", type="integer", example="2"),
     *                      @OA\Property(property="name", type="string", example="Beleza")
     *                 ),
     *                 @OA\Property(
     *                      property="campaigns",
     *                      type="array",
     *                      @OA\Items(
     *                          @OA\Property(property="id", type="integer", example="1"),
     *                          @OA\Property(property="name", type="string", example="Campanha 1"),
     *                          @OA\Property(property="budget", type="number", format="float", example=200),
     *                          @OA\Property(property="description", type="string", example="Descrição da campanha"),
     *                          @OA\Property(property="start_date", type="string", format="date", example="2025-01-15"),
     *                          @OA\Property(property="end_date", type="string", format="date", example="2025-01-16"),
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
     *     schema="Influencer - Create a new Influencer",
     *     required={"name", "instagram_user", "instagram_followers_count", "category"},
     *     @OA\Property(property="name", type="string", example="Anderson de Souza"),
     *     @OA\Property(property="instagram_user", type="string", example="anderson17ads"),
     *     @OA\Property(property="instagram_followers_count", type="number", example=45),
     *     @OA\Property(property="category", type="number", example=2)
     * ),
     * @OA\Post(
     *     path="/api/influencers",
     *     summary="Create a new influencer",
     *     tags={"Influencers"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "instagram_user", "instagram_followers_count", "category"},
     *             @OA\Property(property="name", type="string", example="Anderson de Souza"),
     *             @OA\Property(property="instagram_user", type="string", example="anderson17ads"),
     *             @OA\Property(property="instagram_followers_count", type="number", example=45),
     *             @OA\Property(property="category", type="number", example=2),
     *             @OA\Property(
     *                  property="campaigns",
     *                  type="array",
     *                  @OA\Items(type="number", example=1)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Influencer created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Influencer created successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example="1"),
     *                 @OA\Property(property="name", type="string", example="Anderson de Souza"),
     *                 @OA\Property(property="instagram_user", type="string", example="anderson17ads"),
     *                 @OA\Property(property="instagram_followers_count", type="number", example=45)
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
     *                          "This name is already in use.",
     *                          "The maximum character limit is 45"
     *                      })
     *                 ),
     *                 @OA\Property(property="instagram_user", type="array", 
     *                      @OA\Items(type="string", example={
     *                          "Instagram username is required.", 
     *                          "This Instagram username is already in use.",
     *                          "Instagram username is invalid",
     *                          "The maximum character limit is 45"
     *                      })
     *                 ),
     *                 @OA\Property(property="instagram_followers_count", type="array", 
     *                      @OA\Items(type="string", example={
     *                          "The followers number field is required."
     *                      })
     *                 ),
     *                 @OA\Property(property="category_id", type="array", 
     *                      @OA\Items(type="string", example={
     *                          "The category field is required.", 
     *                          "This category is invalid."
     *                      })
     *                 ),
     *                 @OA\Property(property="campaigns", type="array", 
     *                      @OA\Items(type="string", example={
     *                          "Campaign 1 does not exist."
     *                      })
     *                 ),
     *             )
     *         )
     *     )
     * )
     */
    public function store()
    {
        // 
    }

    /**
     * @OA\Schema(
     *     schema="Influencer - Create a new campaign to influencer",
     *     required={"influencers"},
     *     @OA\Property(
     *          property="campaigns",
     *          type="array",
     *          @OA\Items(type="number", example=1)
     *      )
     * ),
     * @OA\Post(
     *     path="/api/influencers/{id}/campaigns",
     *     summary="Create a new campaign to influencer",
     *     tags={"Influencers"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the influencer",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"campaigns"},
     *             @OA\Property(
     *                  property="campaigns",
     *                  type="array",
     *                  @OA\Items(type="number", example=1)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Campaigns created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Campaigns created successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example="1"),
     *                 @OA\Property(property="name", type="string", example="Anderson de Souza"),
     *                 @OA\Property(property="instagram_user", type="string", example="anderson17ads"),
     *                 @OA\Property(property="instagram_followers_count", type="number", example=45),
     *                 @OA\Property(
     *                      property="category", 
     *                      type="object", 
     *                      @OA\Property(property="id", type="integer", example="2"),
     *                      @OA\Property(property="name", type="string", example="Beleza")
     *                 ),
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
     *                 @OA\Property(property="id", type="array", 
     *                      @OA\Items(type="string", example={
     *                          "The id field is required.",
     *                          "The influencer does not exist."
     *                      })
     *                 ),
     *                 @OA\Property(property="campaigns", type="array", 
     *                      @OA\Items(type="string", example={
     *                          "The id field is required.",
     *                          "Campaign 1 does not exist.",
     *                          "Campaign 1 already exists for this influencer"
     *                      })
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function campaignStore()
    {
        // 
    }
}