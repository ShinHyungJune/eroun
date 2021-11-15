<?php

namespace Database\Factories;

use App\Models\Request;
use Illuminate\Database\Eloquent\Factories\Factory;

class RequestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Request::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "contact" => $this->faker->text,
            "category" => $this->faker->text,
            "time" => rand(0, 10),
            "address" => $this->faker->text,
            "price" => rand(0, 1000),
            "style" => $this->faker->text,
            "comment" => $this->faker->text,
            "required_at" => $this->faker->dateTime,
        ];
    }
}
