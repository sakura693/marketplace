<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Comment; /*追加*/
use App\Models\Item; /*追加*/
use App\Models\User; /*追加*/

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
