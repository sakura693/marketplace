<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Comment; 
use App\Models\Item; 
use App\Models\User; 

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition()
    {
        return [
            'user_id' => Item::factory(),
            'item_id' => User::factory(),
            'comment' => $this->faker->sentence(),
        ];
    }
}
