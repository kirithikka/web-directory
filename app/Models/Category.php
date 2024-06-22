<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    /**
     * A category can have multiple websites.
     */
    public function websites(): HasMany
    {
        return $this->hasMany(Website::class);
    }
}
