<?php

namespace Tests\Feature;

use App\Models\Campaign;
use App\Models\Dsp;
use App\Models\Ssp;
use App\Models\SspCampaign;
use App\Models\SspDsp;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;

class UpdateSspTest extends BaseApiTest
{
    use RefreshDatabase;

    public function test_update_ssp(): void
    {
        /** @var Ssp $model */
        $model = Ssp::factory()->create();

        $payload = Ssp::factory()->makeOne()->toArray();
        $dsps = Dsp::factory()->createMany(3);
        $campaigns = Campaign::factory()->createMany(3);
        $payload['dsp_ids'] = $dsps->getQueueableIds();
        $payload['campaign_ids'] = $campaigns->getQueueableIds();

        $response = $this->mockRequest($this->createUser(), '/api/ssp/'.$model->id, 'PUT', $payload);

        unset($payload['dsp_ids']);
        unset($payload['campaign_ids']);
        $response->assertJson(fn(AssertableJson $json) => $json->has('data',
            fn(AssertableJson $json) => $json->whereAll($payload)->etc())
        );

        $foundSspDsps = SspDsp::where('ssp_id', $model->id)
            ->whereIn('dsp_id', $dsps->getQueueableIds())
            ->count();
        $this->assertEquals(3, $foundSspDsps);

        $foundSspCampaigns = SspCampaign::where('ssp_id', $model->id)
            ->whereIn('campaign_id', $campaigns->getQueueableIds())
            ->count();
        $this->assertEquals(3, $foundSspCampaigns);

        $response->assertStatus(200);
    }
}
