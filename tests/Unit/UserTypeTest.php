<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Enums\UserType;

class UserTypeTest extends TestCase
{
    /**
     * Test user type
     *
     */
    public function test_user_type(): void
    {
        $type1 = UserType::ADMIN;
        $type2 = UserType::CUSTOMER;

        $this->assertTrue($type1->isAdmin());
        $this->assertFalse($type2->isAdmin());
    }
}
