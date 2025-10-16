<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\Business;
use App\Models\Campaign;
use App\Models\Organisation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrganisationSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $models = Organisation::factory()
            ->count(10)
            ->create();

        /** @var Organisation $model */
        foreach ($models as $model) {
            /** @var Building $building */
            $building = Building::factory()
                ->createOne();

            $model->building_id = $building->id;
            $model->save();

            $business = Business::factory()
                ->count(3)
                ->create();

            $model->business()->sync($business->getQueueableIds());
        }
    }
}
