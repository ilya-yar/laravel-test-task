<?php

namespace Tests\Feature;

use Database\Seeders\BusinessSeeder;
use Illuminate\Testing\Fluent\AssertableJson;

class GetSspTest extends BaseApiTest
{
    public function test_get_ssp_list(): void
    {
        $this->seed(BusinessSeeder::class);

        $response = $this->mockRequest($this->createUser(), '/api/ssp');

        $response
            ->assertJson(fn(AssertableJson $json) => $json->hasAll(['data', 'links', 'meta'])
                ->has('data.0', fn(AssertableJson $json) => $json->hasAll([
                    'id',
                    'name',
                    'uuid',
                    'uid',
                    'url',
                    'example_url',
                    'status',
                    'protocol',
                    'bid_type',
                    'revshare',
                    'type',
                    'category',
                    'region',
                    'qps',
                    'allow_feeds',
                    'allow_campaign',
                    'created_at',
                    'updated_at'
                ])->etc()
                )
            );

        $response->assertStatus(200);
    }
}
