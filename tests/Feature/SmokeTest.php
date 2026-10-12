<?php

namespace Tests\Feature;

use Tests\TestCase;

class SmokeTest extends TestCase
{
    public function test_the_health_check_endpoint_responds(): void
    {
        $this->get('/up')->assertOk();
    }

    public function test_guests_are_redirected_to_the_login_page(): void
    {
        $this->get('/')->assertRedirect('/login');
    }

    public function test_the_login_page_is_reachable(): void
    {
        $this->get('/login')->assertOk();
    }
}
