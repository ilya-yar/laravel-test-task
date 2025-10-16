<?php

namespace Tests\Feature;

use App\Models\Campaign;
use App\Models\Dsp;
use App\Models\Ssp;
use App\Models\SspCampaign;
use App\Models\SspDsp;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteSspTest extends BaseApiTest
{
    use RefreshDatabase;

    public function test_delete_ssp(): void
    {
        /** @var Ssp $model */
        $model = Ssp::factory()->create();
        $dsps = Dsp::factory()->createMany(3);
        $campaigns = Campaign::factory()->createMany(3);
        $user = $this->createUser();
        $model->dsps()->sync($dsps);
        $model->campaigns()->sync($campaigns);

        $response = $this->mockRequest($user, '/api/ssp/'.$model->id);
        $response->assertStatus(200);

        $response = $this->mockRequest($user, '/api/ssp/'.$model->id, 'DELETE');
        $response->assertStatus(204);

        $response = $this->mockRequest($user, '/api/ssp/'.$model->id);
        $response->assertStatus(404);

        $foundSspDsps = SspDsp::where('ssp_id', $model->id)
            ->whereIn('dsp_id', $dsps->getQueueableIds())
            ->count();
        $this->assertEquals(0, $foundSspDsps);

        $foundSspCampaigns = SspCampaign::where('ssp_id', $model->id)
            ->whereIn('campaign_id', $campaigns->getQueueableIds())
            ->count();
        $this->assertEquals(0, $foundSspCampaigns);
    }
}
