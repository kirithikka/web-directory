<?php

namespace App\Data\Votes;

use App\Models\Website;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class VoteUnvoteData extends Data
{
    public function __construct(
        public string $website_id,
    ) {
    }

    public static function rules(ValidationContext $context) : array
    {
        return [
            'website_id' => [
                'in:' . Website::pluck('id')->implode(',')
            ]
        ];
    }
}
