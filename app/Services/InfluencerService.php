<?php

namespace App\Services;

use App\Repositories\InfluencerRepository;
use App\Models\Influencer;
use Illuminate\Database\Eloquent\Collection;

class InfluencerService
{
    private $influencerRepository;

    public function __construct(InfluencerRepository $influencerRepository)
    {
        $this->influencerRepository = $influencerRepository;
    }

    /**
     * Retrieves all influencers with the associated campaigns.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllInfluencers(): Collection
    {
        return $this->influencerRepository->getAllInfluencers();
    }

     /**
     * Creates a new influencer and attaches campaigns if provided.
     *
     * @param array $data Data of the influencer to be created.
     * @param array|null $campaigns Campaigns to be associated with the influencer (optional).
     *
     * @return \App\Models\Influencer
     */
    public function createInfluencer(array $data, ?array $campaigns = null): Influencer
    {
        $influencer = $this->influencerRepository->createInfluencer($data);

        if ($campaigns) {
            $this->influencerRepository->attachCampaigns($influencer, $campaigns);
        }

        return $influencer;
    }

    /**
     * Attaches campaigns to an existing influencer based on the provided data.
     *
     * @param array $data Data containing the influencer ID and campaigns to attach.
     *  - 'id': int, The ID of the influencer.
     *  - 'campaigns': array, List of campaign IDs to be associated with the influencer.
     *
     * @return \App\Models\Influencer The updated influencer instance with associated campaigns.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the influencer is not found.
     */
    public function createInfluencerCampaign(array $data): Influencer
    {
        $influencer = $this->influencerRepository->getInfluencer($data['id']);
        $campaigns = $data['campaigns'];

        if ($campaigns) {
            $this->influencerRepository->attachCampaigns($influencer, $campaigns);
        }

        return $influencer;
    }
}
