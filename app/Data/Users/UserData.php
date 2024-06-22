<?php

namespace App\Data\Users;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Password;

class UserData extends Data
{
    public function __construct(
        #[Max(255)]
        public string $name,
        #[Email]
        public string $email,
        #[Password(min: 5)]
        public string $password,
    ) {
    }
}
