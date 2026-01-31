<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Enums\FeatureFlagStatus;

class FeatureFlag extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'name',
        'description',
        'status',
        'global_enabled',
        'percentage_rollout',
        'created_by',
    ];

    protected $casts = [
        'status' => FeatureFlagStatus::class,
        'global_enabled' => 'boolean',
        'percentage_rollout' => 'integer',
    ];

    public function environments(): HasMany
    {
        return $this->hasMany(FeatureEnvironment::class);
    }

    public function userOverrides(): HasMany
    {
        return $this->hasMany(FeatureUserOverride::class);
    }

    public function getEnvironmentValue(string $environment): ?bool
    {
        $envRecord = $this->environments()->where('environment', $environment)->first();
        return $envRecord?->enabled;
    }

    public function getUserOverride(int $userId): ?bool
    {
        $override = $this->userOverrides()->where('user_id', $userId)->first();
        return $override?->enabled;
    }

    public function scopeActive($query)
    {
        return $query->where('status', FeatureFlagStatus::ACTIVE);
    }
}