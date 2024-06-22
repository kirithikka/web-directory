<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryWebsite extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'category_website';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'category_id',
        'website_id',
    ];

    /**
     * Get the website.
     */
    public function website() : BelongsTo
    {
        return $this->belongsTo(Website::class);
    }

    /**
     * Get the category.
     */
    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
