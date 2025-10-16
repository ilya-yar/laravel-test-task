<?php

namespace Tests\Feature;

use App\Models\Dsp;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;

class CreateDspTest extends BaseApiTest
{
    use RefreshDatabase;

    public function test_create_dsp(): void
    {
        /** @var Dsp $model */
        $model = Dsp::factory()->makeOne();
        $payload = $model->getAttributes();

        $response = $this->mockRequest($this->createUser(), '/api/dsp', 'POST', $payload);

        $response->assertJson(fn(AssertableJson $json) => $json->has('data',
            fn(AssertableJson $json) => $json->whereAll($model->toArray())->etc())
        );

        $response->assertStatus(201);
    }
}
