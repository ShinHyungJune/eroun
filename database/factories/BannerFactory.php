<?php

namespace Database\Factories;

use App\Models\Banner;
use Illuminate\Database\Eloquent\Factories\Factory;

class BannerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Banner::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "order" => Banner::count(),
            "title" => $this->faker->title,
            "description" => $this->faker->paragraph,
            "color" => $this->faker->title,
            "secret" => false
        ];
    }
}
