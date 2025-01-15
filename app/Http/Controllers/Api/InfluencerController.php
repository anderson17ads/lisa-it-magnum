<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\InfluencerRequest;
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
     * @param \App\Http\Requests\InfluencerRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(InfluencerRequest $request)
    {
        $influencer = $this->influencerService->createInfluencer(
            $request->validated(),
            $request->input('campaigns', [])
        );

        return ApiResponse::created(new InfluencerResource($influencer));
    }
}
