<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Website extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'name',
        'url',
        'description',
        'deleted_at',
    ];

    /**
     * Fields to search for
     *
     * @var array
     */
    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'url' => $this->url,
            'description' => $this->description,
        ];
    }

    /**
     * A website can belong to multiple category-website
     */
    public function categoryWebsite(): HasMany
    {
        return $this->hasMany(CategoryWebsite::class, 'website_id', 'id')->with('category');
    }

    /**
     * Get the vote details of the website
     *
     */
    public function votes() : HasMany
    {
        return $this->hasMany(Vote::class);
    }
}
