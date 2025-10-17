<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Organisation>
 */
class OrganisationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $phonesCount = rand(1, 10);
        $phones = [];
        for ($i = 0; $i < $phonesCount; $i++) {
            $phones[] = $this->faker->phoneNumber();
        }

        return [
            'title' => $this->faker->company(),
            'phones' => $phones,
        ];
    }
}
