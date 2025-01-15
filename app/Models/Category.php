<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $hidden = [
        'created_at', 
        'updated_at', 
        'deleted_at',
    ];

    protected $fillable = [
        'name',
    ];

    public function influencers()
    {
        return $this->hasMany(Influencer::class);
    }
}