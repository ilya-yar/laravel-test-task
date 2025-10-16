<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;

class LoginTest extends BaseApiTest
{
    use RefreshDatabase;

    public function test_login_with_valid_data(): void
    {
        $payload = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ];

        $response = $this->mockRequest(null, 'api/register', 'POST', $payload);
        $response->assertJson(fn(AssertableJson $json) => $json->
        hasAll(['access_token', 'token_type'])
            ->where('token_type', 'Bearer')
            ->etc()
        );
        $response->assertStatus(200);

        $payload = [
            'email' => 'john@example.com',
            'password' => 'password',
        ];

        $response = $this->mockRequest(null, 'api/login', 'POST', $payload);

        $response->assertJson(fn(AssertableJson $json) => $json->
        hasAll(['access_token', 'token_type'])
            ->where('token_type', 'Bearer')
            ->etc()
        );

        $response->assertStatus(200);
    }

    public function test_login_with_invalid_data(): void
    {
        $payload = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ];

        $response = $this->mockRequest(null, 'api/register', 'POST', $payload);
        $response->assertJson(fn(AssertableJson $json) => $json->
        hasAll(['access_token', 'token_type'])
            ->where('token_type', 'Bearer')
            ->etc()
        );
        $response->assertStatus(200);

        $payload = [
            'email' => 'john@example.com',
            'password' => 'password1',
        ];

        $response = $this->mockRequest(null, 'api/login', 'POST', $payload);
        $response->assertJson(fn(AssertableJson $json) => $json->
        hasAll(['message', 'errors'])
            ->etc()
        );
        $response->assertStatus(422);
    }
}
