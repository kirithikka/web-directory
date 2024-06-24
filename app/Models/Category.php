<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    use Searchable;

    /**
     * @var string
     */
    protected $table = 'categories';

    /**
     * Fields to search for
     *
     * @var array
     */
    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'websites.name' => '',
            'websites.url' => '',
            'websites.description' => '',
        ];
    }

    /**
     * A category can have multiple category-website
     */
    public function categoryWebsite(): HasMany
    {
        return $this->hasMany(CategoryWebsite::class, 'category_id', 'id')->with('website');
    }
}
