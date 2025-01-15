<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ExistsInfluencerInCompaign implements Rule
{
    public function passes($attribute, $value)
    {
        $influencerId = $value;
        $campaignId = request()->route('id');

        $exists = DB::table('campaign_influencer')
            ->where('campaign_id', $campaignId)
            ->where('influencer_id', $influencerId)
            ->exists();

        if ($exists) {
            throw ValidationException::withMessages([
                'campaigns' => "Influencer {$influencerId} already exists for this campaign.",
            ]);
        }

        return true;
    }

    public function message()
    {
        //
    }
}
