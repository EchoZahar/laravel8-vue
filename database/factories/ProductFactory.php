<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::select('id')->first();
        $productSuffix = ['Sweater', 'Pants', 'Glasses', 'Hat', 'Socks'];
        $name = $this->faker->company() . ' ' . Arr::random($productSuffix);
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->realText(350),
            'price' => $this->faker->numberBetween(2000, 100000),
            'author' => $user
        ];
    }
}
