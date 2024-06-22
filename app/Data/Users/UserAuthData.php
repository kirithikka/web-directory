<?php

namespace App\Data\Users;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Password;

class UserAuthData extends Data
{
    public function __construct(
        #[Email]
        public string $email,
        #[Password(min: 5)]
        public string $password,
    ) {
    }
}
