<?php

namespace Tests\Feature;

use App\Models\Campaign;
use App\Models\Ssp;
use App\Models\SspCampaign;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteCampaignTest extends BaseApiTest
{
    use RefreshDatabase;

    public function test_delete_campaign(): void
    {
        /** @var Campaign $model */
        $model = Campaign::factory()->create();
        $user = $this->createUser();

        /** @var Ssp $ssp */
        $ssp = Ssp::factory()->create();
        $ssp->campaigns()->sync([$model->id]);

        $response = $this->mockRequest($user, '/api/campaign/'.$model->id);
        $response->assertStatus(200);

        $response = $this->mockRequest($user, '/api/campaign/'.$model->id, 'DELETE');
        $response->assertStatus(204);

        $response = $this->mockRequest($user, '/api/campaign/'.$model->id);
        $foundSspDsps = SspCampaign::where([
            'campaign_id' => $model->id,
            'ssp_id' => $ssp->id
        ])->count();
        $this->assertEquals(0, $foundSspDsps);
        $response->assertStatus(404);
    }
}
