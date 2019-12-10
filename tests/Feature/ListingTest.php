<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Listing;

class ListingTest extends TestCase
{
  use RefreshDatabase;

  /**
   * リスト作成ページにアクセスできる
   * @test 
   */
  public function get_create_listing_path()
  {
    $user = factory(User::class)->create();
    $response = $this->actingAs($user)->get(route('listings.create'));

    $response->assertStatus(200);
  }

    /**
   * リスト更新ページにアクセスできる
   * @test 
   */
  public function get_edit_listing_path()
  {
    $user = factory(User::class)->create();
    $listing = Listing::create([
      'title' => 'テストタスク',
      'user_id' => $user->id,
    ]);
    $response = $this->actingAs($user)->get(route('listings.edit', ['listing'=>$listing]));

    $response->assertStatus(200);
  }

  /**
   * リストを作成できる
   * @test 
   */
  public function listing_can_be_create()
  {
    $data = [
      'title' => str_repeat('a', 20),
    ];
    $user = factory(User::class)->create();
    $response = $this->actingAs($user)->post(route('listings.store'), $data);

    $response->assertStatus(302)
            ->assertRedirect('/listings');

    $this->assertDatabaseHas('listings', $data);
  }

  /**
   * リスト更新できる
   * @test 
   */
  public function listing_can_be_update()
  {
    $data = [
      'title' => str_repeat('a', 20),
    ];
    $user = factory(User::class)->create();
    $listing = Listing::create([
      'title' => 'テストタスク',
      'user_id' => $user->id,
    ]);
    $response = $this->actingAs($user)->patch(route('listings.update', ['listing'=>$listing, 'title' => str_repeat('a', 20)]));

    $response->assertStatus(302)
              ->assertRedirect('/listings');

    $this->assertDatabaseHas('listings', $data);
  }


  /**
   * リスト削除できる
   * @test 
   */
  public function listing_can_be_destroy()
  {
    $data = [
      'title' => 'テストタスク'
    ];
    $user = factory(User::class)->create();
    $listing = Listing::create([
      'title' => 'テストタスク',
      'user_id' => $user->id,
    ]);
    $response = $this->actingAs($user)->delete(route('listings.destroy', ['listing'=>$listing]));

    $response->assertStatus(302)
              ->assertRedirect('/listings');

    $this->assertDatabaseMissing('listings', $data);
  }
  /** 
  * タイトルが空の場合はバリデーションエラー
  * @test 
  */ 
  public function title_should_not_be_empty()
  {
    $data = [
      'title' => '',
    ];
    $user = factory(User::class)->create();
    $response = $this->actingAs($user)->post(route('listings.store'), $data);

    $response->assertSessionHasErrors([ 'title' => 'タイトルを入力してください。', ]);
  }

  /** 
  * タイトルが20文字より多い場合はバリデーションエラー
  * @test 
  */ 
  public function title_should_not_be_over20()
  {
    $data = [
      'title' => str_repeat('a', 21),
    ];
    $user = factory(User::class)->create();
    $response = $this->actingAs($user)->post(route('listings.store'), $data);

    $response->assertSessionHasErrors([ 'title' => 'タイトルは20文字以下入力してください。', ]);
  }
}
