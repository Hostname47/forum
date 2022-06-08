<?php

namespace Database\Factories;

use App\Models\Vote;
use Illuminate\Database\Eloquent\Factories\Factory;

class VoteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vote::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'votable_id'=>$this->faker->randomDigit(),
            'votable_type'=>$this->faker->text(20),
            'vote'=>$this->faker->randomElement([0,1])
        ];
    }
}
