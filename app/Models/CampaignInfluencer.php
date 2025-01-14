<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CampaignInfluencer extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'influencer_id',
    ];
}