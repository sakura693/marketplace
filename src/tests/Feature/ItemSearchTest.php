<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User; /*追加*/
use App\Models\Item; /*追加*/

class ItemSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_search_items_by_name(){
        $user = User::factory()->create();
        $this->actingAs($user);

        /*ファクトリで商品を作成*/
        $itemA = Item::factory()->create(['name' => 'item A']);
        $itemB = Item::factory()->create(['name' => 'item B']);
        Item::factory()->create(['name' => 'Something Else']);
        
        $response = $this->get('/search?keyword=Item');

        /*itemAとBが表示されることを確認*/
        $response->assertSeeText($itemA->name);
        $response->assertSeeText($itemB->name);
        $response->assertSee($itemA->image);
        $response->assertSee($itemB->image);

        /*Something Elseは表示されないことを確認*/
        $response->assertDontSeeText('Something Else');
    }
}
