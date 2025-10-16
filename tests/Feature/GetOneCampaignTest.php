<?php

namespace Tests\Feature;

use App\Models\Campaign;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;

class GetOneCampaignTest extends BaseApiTest
{
    use RefreshDatabase;

    public function test_get_one_campaign(): void
    {
        /** @var Campaign $model */
        $model = Campaign::factory()->create();

        $response = $this->mockRequest($this->createUser(), '/api/campaign/'.$model->id);

        $response->assertJson(fn(AssertableJson $json) => $json->has('data',
            fn(AssertableJson $json) => $json->whereAll($model->toArray())->etc())
        );

        $response->assertStatus(200);
    }
}
