<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'name' => $this->faker->company(),
            'building_id' => \App\Models\Building::inRandomOrder()->value('id')
        ];
    }

    public function withActivities(int $count): OrganisationFactory
    {
        return $this->afterCreating(function (\App\Models\Organisation $organisation) use ($count) {
            $activities = \App\Models\Activity::inRandomOrder()
                ->take($count)
                ->pluck('id');

            $organisation->activities()->attach($activities);
        });
    }

    public function withPhoneNumbers(int $count): OrganisationFactory
    {
        return $this->afterCreating(function (\App\Models\Organisation $organisation) use ($count) {
            while ($count){
                $organisation->phoneNumbers()->create(['phone_number' => $this->faker->phoneNumber()]);
                $count--;
            }
        });
    }
}
