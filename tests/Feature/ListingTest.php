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
    $response = $this->actingAs($user)->get('/listings/create');

    $response->assertStatus(200);
  }

  /**
   * リストを作成できる
   * @test 
   */
  public function post_create_listing_path()
  {
    $data = [
      'title' => str_repeat('a', 20),
    ];
    $user = factory(User::class)->create();
    $response = $this->actingAs($user)->post('/listings/create', $data);

    $response->assertStatus(302)
            ->assertRedirect('/listings');

    $this->assertDatabaseHas('listings', $data);
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
    $response = $this->actingAs($user)->post('/listings/create', $data);

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
    $response = $this->actingAs($user)->post('/listings/create', $data);

    $response->assertSessionHasErrors([ 'title' => 'タイトルは20文字以下入力してください。', ]);
  }
}
