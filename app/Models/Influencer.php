<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Influencer extends Model
{
    use HasFactory, SoftDeletes;

    protected $hidden = [
        'created_at', 
        'updated_at', 
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'instagram_user',
        'instagram_followers_count',
        'category',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function campaigns()
    {
        return $this->belongsToMany(Campaign::class, 'campaign_influencer');
    }
}