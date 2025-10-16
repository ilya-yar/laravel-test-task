<?php

namespace Tests\Feature;

use Database\Seeders\DspSeeder;
use Illuminate\Testing\Fluent\AssertableJson;

class GetDspTest extends BaseApiTest
{
    public function test_get_dsp_list(): void
    {
        $this->seed(DspSeeder::class);

        $response = $this->mockRequest($this->createUser(), '/api/dsp');

        $response
            ->assertJson(fn(AssertableJson $json) => $json->hasAll(['data', 'links', 'meta'])
                ->has('data.0', fn(AssertableJson $json) => $json->hasAll([
                    'id',
                    'name',
                    'comment',
                    'status',
                    'country',
                    'balance',
                    'max_rps',
                    'type',
                    'category',
                    'url',
                    'protocol',
                    'feed_parser',
                    'customizer',
                    'ref_spoofing',
                    'target_by_pseudosites',
                    'ref_spoofing_host',
                    'bid_type',
                    'revshare',
                    'max_clicks_per_ip24',
                    'ip_mismatch',
                    'proxy',
                    'no_js',
                    'iframe',
                    'headless',
                    'tz_mismatch',
                    'ua_mismatch',
                    'ref_mismatch',
                    'double_click',
                    'rps',
                    'delay_request_optimization',
                    'created_at',
                    'updated_at'
                ])->etc()
                )
            );

        $response->assertStatus(200);
    }
}
