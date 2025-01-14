<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Campaign extends Model
{
    use HasFactory, SoftDeletes;

    protected $hidden = [
        'created_at', 
        'updated_at', 
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'budget',
        'description',
        'start_date',
        'end_date',
    ];

    public function influencers()
    {
        return $this->belongsToMany(Influencer::class, 'campaign_influencer');
    }
}