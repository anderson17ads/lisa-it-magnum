<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ExistsCompaingInInfluencer implements Rule
{
    public function passes($attribute, $value)
    {
        $campaignId = $value;
        $influencerId = request()->route('id');

        $exists = DB::table('campaign_influencer')
            ->where('campaign_id', $campaignId)
            ->where('influencer_id', $influencerId)
            ->exists();

        if ($exists) {
            throw ValidationException::withMessages([
                'campaigns' => "Campaign {$campaignId} already exists for this influencer.",
            ]);
        }

        return true;
    }

    public function message()
    {
        //
    }
}
