<?php

namespace Database\Factories;

use App\Models\NotificationDisable;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationDisableFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = NotificationDisable::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'resource_id' => $this->faker->randomDigit(),
            'resource_type' => $this->faker->text(20),
            'disabled_action' => $this->faker->text(20),
        ];
    }
}
