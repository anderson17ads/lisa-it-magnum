<?php

namespace App\Repositories;

use App\Models\Campaign;
use Illuminate\Database\Eloquent\Collection;

class CampaignRepository
{
    /**
     * Retrieves a campaign by its ID.
     *
     * This method fetches a single campaign from the database using its primary key.
     * If the campaign does not exist, it throws a ModelNotFoundException.
     *
     * @param int $id The ID of the campaign to retrieve.
     *
     * @return \App\Models\Campaign The campaign model associated with the given ID.
     */
    public function getCampaign(int $id): Campaign
    {
        return Campaign::find($id);
    }

    /**
     * Retrieves all campaigns with their associated influencers.
     *
     * This method fetches all campaign records from the database, eager loading
     * their associated influencers to optimize the number of queries.
     *
     * @return \Illuminate\Database\Eloquent\Collection A collection of campaign models with associated influencers.
     */
    public function getAllCampaigns(): Collection
    {
        return Campaign::with('influencers')->get();
    }

    /**
     * Creates a new campaign in the database.
     *
     * This method accepts an array of data and creates a new campaign record
     * in the database.
     *
     * @param array $data The data to create a new campaign.
     *
     * @return \App\Models\Campaign The created campaign model.
     */
    public function createCampaign(array $data): Campaign
    {
        return Campaign::create($data);
    }

    /**
     * Attaches influencers to a given campaign.
     *
     * This method associates the provided influencers with the given campaign.
     * It assumes the influencers exist and attaches them with the current timestamp.
     *
     * @param \App\Models\Campaign $campaign The campaign to which influencers will be attached.
     * @param array $influencers The list of influencer IDs to be attached to the campaign.
     *
     * @return void
     */
    public function attachInfluencers(Campaign $campaign, array $influencers)
    {
        $campaign->influencers()->attach($influencers, ['created_at' => now()]);
    }
}
