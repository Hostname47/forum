<?php

namespace Database\Factories;

use App\Models\{ContactMessage};
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ContactMessageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ContactMessage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'ip' => $this->faker->ipv4(),
            'firstname' => $this->faker->name(),
            'lastname' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'company'=> $this->faker->text(40),
            'phone'=> $this->faker->text(40),
            'message'=> $this->faker->text(40),
        ];
    }
}
