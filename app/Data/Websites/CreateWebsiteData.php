<?php

namespace App\Data\Websites;

use App\Models\Category;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Url;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateWebsiteData extends Data
{
    public function __construct(
        #[Max(255)]
        public string $name,
        #[Max(255), Url, Unique('websites', 'url')]
        public string $url,
        #[Max(255)]
        public string $description,
        public array $category_id,
    ) {
    }

    public static function rules(ValidationContext $context) : array
    {
        return [
            'category' => [
                'in:' . Category::pluck('id')->implode(',')
            ]
        ];
    }
}
