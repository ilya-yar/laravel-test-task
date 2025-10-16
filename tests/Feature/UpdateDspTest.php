<?php

namespace Tests\Feature;

use App\Models\Dsp;
use Illuminate\Support\Facades\Session;
use Illuminate\Testing\Fluent\AssertableJson;

class UpdateDspTest extends BaseApiTest
{
    public function test_update_dsp(): void
    {
        Session::start();

        /** @var Dsp $model */
        $model = Dsp::factory()->create();
        $payload = Dsp::factory()->makeOne()->toArray();

        $response = $this->mockRequest($this->createUser(), '/api/dsp/'.$model->id, 'PUT', $payload);

        $response->assertJson(fn(AssertableJson $json) => $json->has('data',
            fn(AssertableJson $json) => $json->whereAll($payload)->etc())
        );

        $response->assertStatus(200);
    }
}
