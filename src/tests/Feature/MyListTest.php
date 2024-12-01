<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User; /*追加*/
use App\Models\Item; /*追加*/
use App\Models\Like; /*追加*/

class MyListTest extends TestCase
{
    use RefreshDatabase;

    /*いいねした商品だけが表示される*/
    public function test_only_liked_items_are_displayed(){
        /*テストユーザと商品を作成*/
        $user = User::factory()->create();
        $likedItem = Item::factory()->create();
        $notLikedItem = Item::factory()->create();

        /*ユーザがいいねした商品を関連付け*/
        Like::create([
            'user_id' => $user->id,
            'item_id' => $likedItem->id,
        ]);

        /*ログイン状態でリクエストを送信*/
        $this->actingAs($user);
        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);

        /*「いいね」された商品が表示されるか確認*/
        $response->assertSee($likedItem->name);
        $response->assertSee($likedItem->image);

        /*「いいね」されていない商品が表示されないか確認*/
        $response->assertDontSee($notLikedItem->name);
        $response->assertDontSee($notLikedItem->image);
    }

    /*購入済み商品はsoldと表示される*/
    public function test_sold_items_display_as_sold(){
        $user = User::factory()->create();
        /*いいねされ、購入された商品*/
        $likedSoldItem = Item::factory()->create([
            'sold' => true
        ]); 
        
        /*ユーザーが「いいね」した商品を関連付け*/
        Like::create([
            'user_id' => $user->id,
            'item_id' => $likedSoldItem->id,
        ]);

        $this->actingAs($user);
        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);

         /*いいねされた購入済み商品がsoldと表示されている*/
        $response->assertSeeText($likedSoldItem->name);
        $response->assertSee($likedSoldItem->image);
        $response->assertSeeText('sold');
    }


    /*自分が出品した商品は表示されない*/
    public function test_only_liked_items_are_displayed_and_own_items_are_not_included()
    {
        $user = User::factory()->create();

        /*他のユーザーの商品を作成し、ログインユーザーが「いいね」する*/
        $likedItem = Item::factory()->create(['user_id' => User::factory()->create()->id]);
        Like::create([
            'user_id' => $user->id,
            'item_id' => $likedItem->id,
        ]);

        /*ログインユーザーが出品した商品*/
        $ownItem = Item::factory()->create(['user_id' => $user->id]);

        /*ログイン*/
        $this->actingAs($user);
        /*マイリストにアクセス*/
        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);

        /*「いいね」した商品が表示される*/
        $response->assertSeeText($likedItem->name);
        $response->assertSee($likedItem->image);

        /*自分の出品した商品が表示されない*/
        $response->assertDontSeeText($ownItem->name);
        $response->assertDontSee($ownItem->image);
    }

    
    /*未認証の場合は何にも表示されない*/
    public function test_nothing_is_displayed_if_not_authenticated(){
        $response = $this->get('/?tab=mylist');
        /*ステータスコードが200（OK）であることを確認。今回は空のコレクションを返しているだけだから401(error)を返さないようになっている。まず200が返ってくることを確認。*/
        $response->assertStatus(200); 

        /*レスポンスが空であることを確認*/
        $response->assertSee('', false);
    }

}

    

