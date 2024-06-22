<?php

namespace App\Data\Websites;

use Spatie\LaravelData\Data;

class WebsiteQueryParamsData extends Data
{
    public function __construct(
        public ?string $q,
    ) {
    }
}
