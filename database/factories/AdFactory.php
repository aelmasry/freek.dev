<?php

namespace Database\Factories;

use App\Models\Ad;
use Illuminate\Database\Eloquent\Factories\Factory;

/* @var Illuminate\Database\Eloquent\Factory $factory */

class AdFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ad::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $startsAt = now()->addDays(rand(-30, 30));
        $endsAt = $startsAt->copy()->addDays(30);

        return [
        'display_on_url' => $this->faker->boolean(50) ? $this->faker->url : '',
        'text' => $this->faker->sentence(),
        'starts_at' => $startsAt->toDateString(),
        'ends_at' => $endsAt->toDateString(),
    ];
    }
}
