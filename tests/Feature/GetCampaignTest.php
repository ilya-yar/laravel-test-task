<?php

namespace Tests\Feature;

use App\Models\Campaign;
use Database\Seeders\OrganisationSeeder;
use Illuminate\Testing\Fluent\AssertableJson;

class GetCampaignTest extends BaseApiTest
{
    public function test_get_campaign_list(): void
    {
        $this->seed(OrganisationSeeder::class);

        $response = $this->mockRequest($this->createUser(), '/api/campaign');

        $response
            ->assertJson(fn(AssertableJson $json) => $json->hasAll(['data', 'links', 'meta'])
                ->has('data.0', fn(AssertableJson $json) => $json->hasAll(
                    array_keys(Campaign::factory()->makeOne()->getAttributes()))->etc()
                )
            );

        $response->assertStatus(200);
    }
}
