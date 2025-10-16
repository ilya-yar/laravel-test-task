<?php

namespace Tests\Feature;

use App\Models\Campaign;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;

class UpdateCampaignTest extends BaseApiTest
{
    use RefreshDatabase;

    public function test_update_campaign(): void
    {
        /** @var Campaign $model */
        $model = Campaign::factory()->create();
        $payload = Campaign::factory()->makeOne()->toArray();

        $response = $this->mockRequest($this->createUser(), '/api/campaign/'.$model->id, 'PUT', $payload);

        $response->assertJson(fn(AssertableJson $json) => $json->has('data',
            fn(AssertableJson $json) => $json->whereAll($payload)->etc())
        );

        $response->assertStatus(200);
    }
}
