<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCampaignRequest;
use App\Http\Requests\CreateInfluencersRequest;
use App\Http\Resources\CampaignResource;
use App\Services\CampaignService;

class CampaignController extends Controller
{
    private $campaignService;

    public function __construct(CampaignService $campaignService)
    {
        $this->campaignService = $campaignService;
    }

    /**
     * Retrieves all campaigns and their associated data.
     *
     * This method calls the service layer to fetch all campaigns and returns a JSON response
     * with the list of campaigns.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response containing the collection of campaigns.
     */
    public function index()
    {
        $campaigns = $this->campaignService->getAllCampaigns();

        return ApiResponse::success(
            CampaignResource::collection($campaigns),
            'List of campaigns'
        );
    }

    /**
     * Creates a new campaign and returns the response.
     *
     * This method validates the request data, creates a new campaign, and optionally associates
     * influencers with the campaign.
     *
     * @param \App\Http\Requests\CreateCampaignRequest $request The request containing campaign data.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response with the created campaign details.
     *
     * @throws \Illuminate\Validation\ValidationException If the request data is invalid.
     */
    public function store(CreateCampaignRequest $request)
    {
        $campaign = $this->campaignService->createCampaign(
            $request->validated(),
            $request->input('influencers', [])
        );

        return ApiResponse::created(
            new CampaignResource($campaign),
            'Campaign created successfully'
        );
    }

    /**
     * Associates influencers with an existing campaign and returns the response.
     *
     * This method validates the request data, retrieves the specified campaign, and attaches
     * the provided influencers to the campaign.
     *
     * @param \App\Http\Requests\CreateInfluencersRequest $request The request containing campaign ID and influencer IDs.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response with the updated campaign details.
     *
     * @throws \Illuminate\Validation\ValidationException If the request data is invalid.
     */
    public function influencerStore(CreateInfluencersRequest $request)
    {
        $influencerCampaign = $this->campaignService->createInfluencerCampaign(
            $request->validated(),
        );

        return ApiResponse::created(
            new CampaignResource($influencerCampaign),
            'Influencers created successfully'
        );
    }
}
