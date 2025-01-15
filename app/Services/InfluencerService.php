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
}
