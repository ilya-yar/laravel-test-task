<?php

namespace Tests\Feature;

use App\Models\Campaign;
use App\Models\Dsp;
use App\Models\Ssp;
use App\Models\SspCampaign;
use App\Models\SspDsp;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateSspTest extends BaseApiTest
{
    use RefreshDatabase;

    public function test_create_ssp(): void
    {
        $model = Ssp::factory()->makeOne();
        $payload = $model->getAttributes();
        $dsps = Dsp::factory()->createMany(3);
        $campaigns = Campaign::factory()->createMany(3);
        $payload['dsp_ids'] = $dsps->getQueueableIds();
        $payload['campaign_ids'] = $campaigns->getQueueableIds();

        $response = $this->mockRequest($this->createUser(), '/api/ssp', 'POST', $payload);

        $response->assertStatus(201);

        $expectedStructure = [
            'data' => array_keys($model->getAttributes())
        ];

        $response->assertJsonStructure($expectedStructure);

        $foundSspDsps = SspDsp::where('ssp_id', $response['data']['id'])
            ->whereIn('dsp_id', $dsps->getQueueableIds())
            ->count();
        $this->assertEquals(3, $foundSspDsps);

        $foundSspCampaigns = SspCampaign::where('ssp_id', $response['data']['id'])
            ->whereIn('campaign_id', $campaigns->getQueueableIds())
            ->count();
        $this->assertEquals(3, $foundSspCampaigns);
    }
}
