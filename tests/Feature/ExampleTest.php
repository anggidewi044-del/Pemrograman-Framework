<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_assets_use_https_behind_a_trusted_proxy(): void
    {
        $response = $this
            ->withServerVariables(['REMOTE_ADDR' => '10.0.0.1'])
            ->withHeaders([
                'X-Forwarded-Host' => 'eventrize-production.up.railway.app',
                'X-Forwarded-Proto' => 'https',
                'X-Forwarded-Port' => '443',
            ])
            ->get('/');

        $response->assertOk();
        $response->assertSee(
            'https://eventrize-production.up.railway.app/css/landing.css',
            escape: false,
        );
    }
}
