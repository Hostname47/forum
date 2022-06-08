<?php

namespace Database\Factories;

use App\Models\{EmojiFeedback};
use Illuminate\Database\Eloquent\Factories\Factory;

class EmojiFeedbackFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EmojiFeedback::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'emoji_feedback' => $this->faker->randomElement(['sad', 'sceptic', 'so-so', 'happy', 'veryhappy']),
            'ip' => $this->faker->ipv4(),
        ];
    }
}
