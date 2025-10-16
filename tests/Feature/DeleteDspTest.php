<?php

namespace Tests\Feature;

use App\Models\Dsp;
use App\Models\Ssp;
use App\Models\SspDsp;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteDspTest extends BaseApiTest
{
    use RefreshDatabase;

    public function test_delete_dsp(): void
    {
        /** @var Dsp $model */
        $model = Dsp::factory()->create();
        $user = $this->createUser();

        /** @var Ssp $ssp */
        $ssp = Ssp::factory()->create();
        $ssp->dsps()->sync([$model->id]);

        $response = $this->mockRequest($user, '/api/dsp/'.$model->id);
        $response->assertStatus(200);

        $response = $this->mockRequest($user, '/api/dsp/'.$model->id, 'DELETE');
        $response->assertStatus(204);

        $response = $this->mockRequest($user, '/api/dsp/'.$model->id);
        $response->assertStatus(404);

        $foundSspDsps = SspDsp::where([
            'dsp_id' => $model->id,
            'ssp_id' => $ssp->id
        ])->count();
        $this->assertEquals(0, $foundSspDsps);
    }
}
