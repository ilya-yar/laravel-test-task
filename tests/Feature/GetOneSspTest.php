<?php

namespace Tests\Feature;

use App\Models\Ssp;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;

class GetOneSspTest extends BaseApiTest
{
    use RefreshDatabase;

    public function test_get_one_ssp(): void
    {
        /** @var Ssp $model */
        $model = Ssp::factory()->create();

        $response = $this->mockRequest($this->createUser(), '/api/ssp/'.$model->id);

        $response->assertJson(fn(AssertableJson $json) => $json->has('data',
            fn(AssertableJson $json) => $json->whereAll($model->toArray())->etc())
        );

        $response->assertStatus(200);
    }
}
