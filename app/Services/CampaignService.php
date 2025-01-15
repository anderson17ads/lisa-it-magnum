<?php

namespace App\Services;

use App\Repositories\CampaignRepository;
use App\Models\Campaign;
use Illuminate\Database\Eloquent\Collection;

class CampaignService
{
    private $campaignRepository;

    public function __construct(CampaignRepository $campaignRepository)
    {
        $this->campaignRepository = $campaignRepository;
    }

    /**
     * Retrieves all campaigns with their associated data.
     *
     * This method fetches all campaign records from the database.
     *
     * @return \Illuminate\Database\Eloquent\Collection A collection of campaign models.
     */
    public function getAllCampaigns(): Collection
    {
        return $this->campaignRepository->getAllCampaigns();
    }

    /**
     * Creates a new campaign and associates influencers if provided.
     *
     * This method validates the provided data, creates a new campaign, and attaches
     * the given influencers to the campaign if available.
     *
     * @param array $data Data for the campaign to be created.
     * @param array|null $influencers A list of influencer IDs to be associated with the campaign (optional).
     *
     * @return \App\Models\Campaign The created campaign instance.
     */
    public function createCampaign(array $data, ?array $influencers = null): Campaign
    {
        $campaign = $this->campaignRepository->createCampaign($data);

        if ($influencers) {
            $this->campaignRepository->attachInfluencers($campaign, $influencers);
        }

        return $campaign;
    }

    /**
     * Associates influencers with an existing campaign and returns the updated campaign.
     *
     * This method finds a specific campaign using the provided ID and attaches the given
     * influencers to it.
     *
     * @param array $data Data containing the campaign ID and influencer IDs to associate.
     *  - 'id': int, The ID of the campaign.
     *  - 'influencers': array|null, A list of influencer IDs to associate (optional).
     *
     * @return \App\Models\Campaign The updated campaign instance with associated influencers.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the specified campaign is not found.
     */
    public function createInfluencerCampaign(array $data): Campaign
    {
        $campaign = $this->campaignRepository->getCampaign($data['id']);
        $influencers = $data['influencers'] ?? [];

        if ($influencers) {
            $this->campaignRepository->attachInfluencers($campaign, $influencers);
        }

        return $campaign;
    }
}
