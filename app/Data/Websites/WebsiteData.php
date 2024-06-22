<?php

namespace App\Data\Websites;

use Carbon\Carbon;
use Spatie\LaravelData\Data;

class WebsiteData extends Data
{
    public function __construct(
        public int $user_id,
        public string $name,
        public string $url,
        public string $description,
        public ?Carbon $deleted_at,
        public Carbon $created_at,
        public Carbon $updated_at,
    ) {
    }
}
