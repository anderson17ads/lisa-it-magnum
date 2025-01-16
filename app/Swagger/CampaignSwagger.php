<?php

namespace App\Swagger;

class CampaignSwagger
{
    /**
     * @OA\Get(
     *     path="/api/campaigns",
     *     summary="List of campaigns",
     *     tags={"Campaigns"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of campaigns",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="List of campaigns"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example="1"),
     *                 @OA\Property(property="name", type="string", example="Campanha 1"),
     *                 @OA\Property(property="budget", type="number", format="float", example=200),
     *                 @OA\Property(property="description", type="string", example="Descrição da campanha"),
     *                 @OA\Property(property="start_date", type="string", format="date", example="2025-01-15"),
     *                 @OA\Property(property="end_date", type="string", format="date", example="2025-01-16"),
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
     *     schema="Campaign - Create a new Campaign",
     *     required={"name", "budget", "description", "start_date", "end_date"},
     *     @OA\Property(property="name", type="string", example="Campanha 1"),
     *     @OA\Property(property="budget", type="number", format="float", example=200),
     *     @OA\Property(property="description", type="string", example="Descrição da campanha"),
     *     @OA\Property(property="start_date", type="string", format="date", example="2025-01-15"),
     *     @OA\Property(property="end_date", type="string", format="date", example="2025-01-16"),
     * ),
     * @OA\Post(
     *     path="/api/campaigns",
     *     summary="Create a new campaign",
     *     tags={"Campaigns"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "budget", "description", "start_date", "end_date"},
     *             @OA\Property(property="name", type="string", example="Campanha 1"),
     *             @OA\Property(property="budget", type="number", format="float", example=200),
     *             @OA\Property(property="description", type="string", example="Descrição da campanha"),
     *             @OA\Property(property="start_date", type="string", format="date", example="2025-01-15"),
     *             @OA\Property(property="end_date", type="string", format="date", example="2025-01-16"),
     *             @OA\Property(
     *                  property="influencers",
     *                  type="array",
     *                  @OA\Items(type="number", example=1)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Campaign created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Campaign created successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="number", example=1),
     *                 @OA\Property(property="name", type="string", example="Campanha 1"),
     *                 @OA\Property(property="budget", type="number", format="float", example=200),
     *                 @OA\Property(property="description", type="string", example="Descrição da campanha"),
     *                 @OA\Property(property="start_date", type="string", format="date", example="2025-01-15"),
     *                 @OA\Property(property="end_date", type="string", format="date", example="2025-01-16")
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
     *                 @OA\Property(property="budget", type="array", 
     *                      @OA\Items(type="string", example={
     *                          "Budget field is required.", 
     *                          "Budget field is not a number."
     *                      })
     *                 ),
     *                 @OA\Property(property="description", type="array", 
     *                      @OA\Items(type="string", example={
     *                          "Description field is required."
     *                      })
     *                 ),
     *                 @OA\Property(property="start_date", type="array", 
     *                      @OA\Items(type="string", example={
     *                          "Start date field is required.", 
     *                          "Start date field is invalid.",
     *                      })
     *                 ),
     *                 @OA\Property(property="end_date", type="array", 
     *                      @OA\Items(type="string", example={
     *                          "End date field is required.", 
     *                          "End date field is invalid.",
     *                          "The final date field cannot be less than the start date",
     *                      })
     *                 ),
     *                 @OA\Property(property="influencers", type="array", 
     *                      @OA\Items(type="string", example={
     *                          "Influencer 1 does not exist."
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
     *     schema="Campaign - Create a new influencer to campaign",
     *     required={"influencers"},
     *     @OA\Property(
     *          property="influencers",
     *          type="array",
     *          @OA\Items(type="number", example=1)
     *      )
     * ),
     * @OA\Post(
     *     path="/api/campaigns/{id}/influencers",
     *     summary="Create a new influencer to campaign",
     *     tags={"Campaigns"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the Campaign",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"influencers"},
     *             @OA\Property(
     *                  property="influencers",
     *                  type="array",
     *                  @OA\Items(type="number", example=1)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Influencers created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Influencers created successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="number", example=1),
     *                 @OA\Property(property="name", type="string", example="Campanha 1"),
     *                 @OA\Property(property="budget", type="number", format="float", example=200),
     *                 @OA\Property(property="description", type="string", example="Descrição da campanha"),
     *                 @OA\Property(property="start_date", type="string", format="date", example="2025-01-15"),
     *                 @OA\Property(property="end_date", type="string", format="date", example="2025-01-16")
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
     *                          "The name field is required.",
     *                          "The campaign does not exist."
     *                      })
     *                 ),
     *                 @OA\Property(property="influencers", type="array", 
     *                      @OA\Items(type="string", example={
     *                          "The id field is required.",
     *                          "Influencer 1 does not exist.",
     *                          "Influencer 1 already exists for this campaign"
     *                      })
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function influencerStore()
    {
        // 
    }
}