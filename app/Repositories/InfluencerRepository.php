<?php

namespace App\Repositories;

use App\Models\Influencer;
use Illuminate\Database\Eloquent\Collection;

class InfluencerRepository
{
    /**
     * Retrieves all influencers with their associated campaigns.
     *
     * This method fetches all influencer records from the database, eager loading
     * their associated campaigns to optimize the number of queries.
     *
     * @return \Illuminate\Database\Eloquent\Collection A collection of influencer models with associated campaigns.
     */
    public function getAllInfluencers(): Collection
    {
        return Influencer::with('campaigns')->get();
    }

    /**
     * Creates a new influencer in the database.
     *
     * This method accepts an array of data and creates a new influencer record
     * in the database.
     *
     * @param array $data The data to create a new influencer.
     *
     * @return \App\Models\Influencer The created influencer model.
     */
    public function createInfluencer(array $data): Influencer
    {
        return Influencer::create($data);
    }

    /**
     * Attaches campaigns to a given influencer.
     *
     * This method associates the provided campaigns with the given influencer.
     * It assumes the campaigns exist and attaches them with the current timestamp.
     *
     * @param \App\Models\Influencer $influencer The influencer to which campaigns will be attached.
     * @param array $campaigns The list of campaigns to be attached to the influencer.
     *
     * @return void
     */
    public function attachCampaigns(Influencer $influencer, array $campaigns)
    {
        $influencer->campaigns()->attach($campaigns, ['created_at' => now()]);
    }
}
