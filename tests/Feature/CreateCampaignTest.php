<?php

namespace Tests\Feature;

use App\Models\Campaign;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;

class CreateCampaignTest extends BaseApiTest
{
    use RefreshDatabase;

    public function test_create_campaign(): void
    {
        $model = Campaign::factory()->makeOne();
        $payload = $model->getAttributes();

        $response = $this->mockRequest($this->createUser(), '/api/campaign', 'POST', $payload);

        $response->assertJson(fn(AssertableJson $json) => $json->has('data',
            fn(AssertableJson $json) => $json->whereAll($model->toArray())->etc())
        );

        $response->assertStatus(201);
    }
}
