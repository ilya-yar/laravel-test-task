<?php

namespace Tests\Feature;

use App\Models\Dsp;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;

class GetOneDspTest extends BaseApiTest
{
    use RefreshDatabase;

    public function test_get_one_dsp(): void
    {
        /** @var Dsp $model */
        $model = Dsp::factory()->create();

        $response = $this->mockRequest($this->createUser(), '/api/dsp/'.$model->id);

        $response->assertJson(fn(AssertableJson $json) => $json->has('data',
            fn(AssertableJson $json) => $json->whereAll($model->toArray())->etc())
        );

        $response->assertStatus(200);
    }
}
