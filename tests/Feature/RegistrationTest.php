<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;

class RegistrationTest extends BaseApiTest
{
    use RefreshDatabase;

    public function test_registration_with_valid_data(): void
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
    }

    public function test_registration_passwords_mismatch(): void
    {
        $payload = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password',
            'password_confirmation' => 'password1'
        ];

        $response = $this->mockRequest(null, 'api/register', 'POST', $payload);

        $response->assertJson(fn(AssertableJson $json) => $json->
        hasAll(['message', 'errors'])
            ->etc()
        );

        $response->assertStatus(422);
    }

    public function test_registration_short_password(): void
    {
        $payload = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => '123',
            'password_confirmation' => '123'
        ];

        $response = $this->mockRequest(null, 'api/register', 'POST', $payload);

        $response->assertJson(fn(AssertableJson $json) => $json->
        hasAll(['message', 'errors'])
            ->etc()
        );

        $response->assertStatus(422);
    }

    public function test_registration_login_already_taken(): void
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

        $response = $this->mockRequest(null, 'api/register', 'POST', $payload);
        $response->assertJson(fn(AssertableJson $json) => $json->
        hasAll(['message', 'errors'])
            ->etc()
        );
        $response->assertStatus(422);
    }
}
