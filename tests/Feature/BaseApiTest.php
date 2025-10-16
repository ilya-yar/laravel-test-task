<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class BaseApiTest extends TestCase
{
    use RefreshDatabase;

    protected function createUser()
    {
        $user = User::factory()->create();

        return $user;
    }

    protected function mockRequest($user, $endpoint, $method = 'GET', array $payload = [])
    {
        return $this->withHeaders([
            'Accepted' => 'application/json',
            'Authorization' => ($user) ? 'Bearer '.$user->createToken('test-token')->plainTextToken : '',
        ])->json($method, $endpoint, $payload);
    }
}
