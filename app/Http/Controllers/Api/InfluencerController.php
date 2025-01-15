<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateInfluencerRequest;
use App\Http\Requests\CreateCampaignsRequest;
use App\Http\Resources\InfluencerResource;
use App\Services\InfluencerService;

class InfluencerController extends Controller
{
    private $influencerService;

    public function __construct(InfluencerService $influencerService)
    {
        $this->influencerService = $influencerService;
    }

    /**
     * Retrieves all influencers with their associated campaigns.
     *
     * This method calls the service to fetch all influencers, eager loading their campaigns.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $influencers = $this->influencerService->getAllInfluencers();

        return ApiResponse::success(
            InfluencerResource::collection($influencers),
            'List of influencers'
        );
    }

    /**
     * Creates a new influencer and returns the response.
     *
     * This method validates the request data, creates a new influencer, and associates campaigns if provided.
     *
     * @param \App\Http\Requests\CreateInfluencerRequest $request
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateInfluencerRequest $request)
    {
        $influencer = $this->influencerService->createInfluencer(
            $request->validated(),
            $request->input('campaigns', [])
        );

        return ApiResponse::created(
            new InfluencerResource($influencer),
            'Influencer created successfully'
        );
    }

    /**
     * Associates campaigns with an existing influencer and returns the response.
     *
     * This method validates the request data, finds the specified influencer, 
     * and attaches the provided campaigns to the influencer.
     *
     * @param \App\Http\Requests\CreateCampaignsRequest $request The request containing influencer ID and campaign data.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response with the updated influencer and associated campaigns.
     *
     * @throws \Illuminate\Validation\ValidationException If the request data is invalid.
     */
    public function campaignStore(CreateCampaignsRequest $request)
    {
        $influencerCampaign = $this->influencerService->createInfluencerCampaign(
            $request->validated(),
        );

        return ApiResponse::created(
            new InfluencerResource($influencerCampaign),
            'Campaigns created successfully'
        );
    }
}
