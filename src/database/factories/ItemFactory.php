<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Item; /*追加*/
use App\Models\User; /*追加*/
use App\Models\Status; /*追加*/

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'status_id' => Status::inRandomOrder()->first()->id,
            'image' => $this->faker->imageURL(640, 480, true, 'Faker'),
            'name' => $this->faker->word(),
            'price' => $this->faker->numberBetween(100,10000),
            'description' => $this->faker->sentence(),
            'sold' => $this->faker->boolean(),
        ];
    }
}
