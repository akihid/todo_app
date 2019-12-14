<?php

namespace Tests\Feature;

use App\User;
use App\Listing;
use App\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Carbon\Carbon;

class TaskTest extends TestCase
{
  use RefreshDatabase;

  /**
   * タスク作成ページにアクセスできる
   * @test 
   */
  public function get_create_task_path()
  {
    $user = factory(User::class)->create();
    $listing = factory(Listing::class)->create([
      'title' => 'テストタスク',
      'user_id' => $user->id,
    ]);

    $response = $this->actingAs($user)->get(route('tasks.create', ['listing'=>$listing]));

    $response->assertStatus(200);
  }

    /**
   * タスク更新ページにアクセスできる
   * @test 
   */
  public function get_edit_task_path()
  {
    $user = factory(User::class)->create();
    $listing = factory(Listing::class)->create([
      'title' => 'テストリスト',
      'user_id' => $user->id,
    ]);
    $task = factory(Task::class)->create([
      'listing_id' => $listing->id,
      'title' => 'テストタスク', 
    ]);
    $response = $this->actingAs($user)->get(route('tasks.edit', ['task'=>$task, 'listing' => $listing]));

    $response->assertStatus(200);
  }

  /**
   * タスクを作成できる
   * @test 
   */
  public function task_can_be_create()
  {
    $user = factory(User::class)->create();
    $listing = factory(Listing::class)->create([
      'title' => 'テストリスト',
      'user_id' => $user->id,
    ]);
    $data = [
      'title' => 'テストタスク',
      'start_line'=>Carbon::today()->format('Y/m/d'),
      'dead_line'=> Carbon::today()->format('Y/m/d'),
    ];

    $response = $this->actingAs($user)->post(route('tasks.store', ['listing' => $listing]), $data);

    $response->assertStatus(302)
              ->assertRedirect(route('tasks.index', ['listing' => $listing]));

    $this->assertDatabaseHas('tasks', $data);
  }

  /**
   * タスク更新できる
   * @test 
   */
  public function task_can_be_update()
  {
    $user = factory(User::class)->create();
    $listing = factory(Listing::class)->create([
      'title' => 'テストリスト',
      'user_id' => $user->id,
    ]);
    $task = factory(Task::class)->create([
      'title' => 'テストタスク',
      'listing_id' => $listing->id,
    ]);
    $data = [
      'title' => '更新タスク',
      'status' => 2,
      'start_line'=>Carbon::today()->format('Y/m/d'),
      'dead_line'=> Carbon::today()->format('Y/m/d'),
      'listing_id' => $listing->id,
    ];

    $response = $this->actingAs($user)->patch(route('tasks.update', ['listing' => $listing, 'task' => $task]), $data);

    $response->assertStatus(302)
              ->assertRedirect(route('tasks.index', ['listing' => $listing]));

    $this->assertDatabaseHas('tasks', $data);
  }


  /**
   * タスク削除できる
   * @test 
   */
  public function task_can_be_destroy()
  {
    $user = factory(User::class)->create();
    $listing = factory(Listing::class)->create([
      'title' => 'テストリスト',
      'user_id' => $user->id,
    ]);
    $task = factory(Task::class)->create([
      'title' => 'テストタスク',
      'listing_id' => $listing->id,
    ]);

    $response = $this->actingAs($user)->delete(route('tasks.destroy', ['listing' => $listing, 'task'=>$task]));

    $response->assertStatus(302)
              ->assertRedirect(route('tasks.index', ['listing' => $listing]));

    $this->assertDatabaseMissing('tasks', ['title' => 'テストタスク']);
  }

  /** 
  * タイトルが空の場合はバリデーションエラー
  * @test 
  */ 
  public function title_should_not_be_empty()
  {
    $user = factory(User::class)->create();
    $listing = factory(Listing::class)->create([
      'title' => 'テストリスト',
      'user_id' => $user->id,
    ]);
    $data = [
      'title' => '',
      'start_line'=>Carbon::today()->format('Y/m/d'),
      'dead_line'=> Carbon::today()->format('Y/m/d'),
    ];

    $response = $this->actingAs($user)->post(route('tasks.store', ['listing' => $listing]), $data);

    $response->assertSessionHasErrors([ 'title' => 'タイトルを入力してください。', ]);
  }

  /** 
  * タイトルが50文字より多い場合はバリデーションエラー
  * @test 
  */ 
  public function title_should_not_be_over50()
  {
    $user = factory(User::class)->create();
    $listing = factory(Listing::class)->create([
      'title' => 'テストリスト',
      'user_id' => $user->id,
    ]);
    $data = [
      'title' => str_repeat('a', 51),
      'start_line'=>Carbon::today()->format('Y/m/d'),
      'dead_line'=> Carbon::today()->format('Y/m/d'),
    ];

    $response = $this->actingAs($user)->post(route('tasks.store', ['listing' => $listing]), $data);

    $response->assertSessionHasErrors([ 'title' => 'タイトルは50文字以下入力してください。', ]);
  }


  /** 
  * 開始日が空の場合はバリデーションエラー
  * @test 
  */ 
  public function start_line_should_not_be_empty()
  {
    $user = factory(User::class)->create();
    $listing = factory(Listing::class)->create([
      'title' => 'テストリスト',
      'user_id' => $user->id,
    ]);
    $data = [
      'title' => 'テストタイトル',
      // 'start_line'=>Carbon::today()->format('Y/m/d'),
      'dead_line'=> Carbon::today()->format('Y/m/d'),
    ];

    $response = $this->actingAs($user)->post(route('tasks.store', ['listing' => $listing]), $data);

    $response->assertSessionHasErrors([ 'start_line' => '開始日を入力してください。', ]);
  }

  /** 
  * 開始日が過去日の場合はバリデーションエラー
  * @test 
  */ 
  public function start_line_should_not_be_past()
  {
    $user = factory(User::class)->create();
    $listing = factory(Listing::class)->create([
      'title' => 'テストリスト',
      'user_id' => $user->id,
    ]);
    $data = [
      'title' => 'テストタイトル',
      'start_line'=>Carbon::yesterday()->format('Y/m/d'),
      'dead_line'=> Carbon::today()->format('Y/m/d'),
    ];

    $response = $this->actingAs($user)->post(route('tasks.store', ['listing' => $listing]), $data);

    $response->assertSessionHasErrors([ 'start_line' => '開始日 には今日以降の日付を入力してください。', ]);
  }

  /** 
  * 期限日が空の場合はバリデーションエラー
  * @test 
  */ 
  public function dead_line_should_not_be_empty()
  {
    $user = factory(User::class)->create();
    $listing = factory(Listing::class)->create([
      'title' => 'テストリスト',
      'user_id' => $user->id,
    ]);
    $data = [
      'title' => 'テストタイトル',
      'start_line'=>Carbon::today()->format('Y/m/d'),
    ];

    $response = $this->actingAs($user)->post(route('tasks.store', ['listing' => $listing]), $data);

    $response->assertSessionHasErrors([ 'dead_line' => '期限を入力してください。', ]);
  }

  /** 
  * 期限が開始日より過去日の場合はバリデーションエラー
  * @test 
  */ 
  public function dead_line_should_not_be_past_start_line()
  {
    $user = factory(User::class)->create();
    $listing = factory(Listing::class)->create([
      'title' => 'テストリスト',
      'user_id' => $user->id,
    ]);
    $data = [
      'title' => 'テストタイトル',
      'start_line'=>Carbon::today()->format('Y/m/d'),
      'dead_line'=> Carbon::yesterday()->format('Y/m/d'),
    ];

    $response = $this->actingAs($user)->post(route('tasks.store', ['listing' => $listing]), $data);

    $response->assertSessionHasErrors([ 'dead_line' => '期限は開始日以降の日付を入力してください。', ]);
  }



}
