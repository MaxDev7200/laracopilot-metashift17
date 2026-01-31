<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeatureEnvironment extends Model
{
    use HasFactory;

    protected $fillable = [
        'feature_flag_id',
        'environment',
        'enabled',
    ];

    protected $casts = [
        'enabled' => 'boolean',
    ];

    public function featureFlag(): BelongsTo
    {
        return $this->belongsTo(FeatureFlag::class);
    }
}