<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activity>
 */
class ActivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->text(50),
            'parent_activity_id' => function () {
                if ($this->faker->boolean(30)) {
                    return \App\Models\Activity::inRandomOrder()->value('id');
                }
                return null;
            },
        ];
    }
}
