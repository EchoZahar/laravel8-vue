<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::select('id')->first();
        $name = $this->faker->jobTitle();
        $nameArr = explode(' ', $name);
        $name = trim($nameArr[0]);
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'parent_id' => 0,
            'published' => 1,
            'author' => $user,
        ];
    }
}
