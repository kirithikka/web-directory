<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vote extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'website_id',
        'deleted_at',
    ];

    /**
     * Get the website.
     *
     */
    public function website() : BelongsTo
    {
        return $this->belongsTo(Website::class);
    }

    /**
     * Get the user.
     *
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
