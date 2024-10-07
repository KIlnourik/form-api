<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FormApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_making_an_api_request(): void
    {
        $response = $this->post('/api/form', [
            'name' => 'test name',
            'email' => 'test@test.com',
            'phone' => '0123456789',
            'profession' => 'test profession',
            'region' => 'test region',
            'product' => 'test product',
        ]);

        $response->assertStatus(200);
    }
}
