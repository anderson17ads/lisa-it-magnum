<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\InfluencerRequest;
use App\Http\Resources\InfluencerResource;
use App\Services\InfluencerService;
use Illuminate\Http\JsonResponse;

class InfluencerController extends Controller
{
    private $influencerService;

    public function __construct(InfluencerService $influencerService)
    {
        $this->influencerService = $influencerService;
    }

    public function index()
    {
        $influencers = $this->influencerService->getAllInfluencers();

        return response()->json([
            'message' => 'List of influencers',
            'data' => InfluencerResource::collection($influencers),
        ], JsonResponse::HTTP_OK);
    }

    public function store(InfluencerRequest $request)
    {
        $influencer = $this->influencerService->createInfluencer(
            $request->validated(),
            $request->input('campaigns', [])
        );

        return new InfluencerResource($influencer);
    }
}
