<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CampaignInfluencer extends Pivot
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'influencer_id',
    ];
}