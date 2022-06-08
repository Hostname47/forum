<?php

namespace Database\Factories;

use App\Models\Notification;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Notification::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->uuid(),
            'type' => $this->faker->text(40),
            'notifiable_type' => $this->faker->text(40),
            'data'=>json_encode([
                'action_user' => $this->faker->randomDigit(),
                'action_type' => $this->faker->text(20),
            ])
        ];
    }
}
