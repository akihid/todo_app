<?php

namespace App\Http\Controllers;

use App\Listing;
use App\Task;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\TaskRequest;


class TaskController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('listing_show_auth');
  }
  
  /**
   * Display a listing of the resource.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  Listing $listing
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request, Listing $listing)
  {

    $listings = Auth::user()->listings()->get();

    // 検索条件の値を取得
    $search_params['search_title'] = $request->input('search_title');
    $search_params['search_status']= $request->input('search_status');
    $search_params['search_tag'] = $request->input('search_tag');
    $search_params['search_deadline_start']= $request->input('search_deadline_start');
    $search_params['search_deadline_end']= $request->input('search_deadline_end');
    $search_params['sort_by']= $request->input('sort_by');

    // リストに紐づくタスクを取得
    $tasks = $listing->tasks()
                      ->SearchTitle($search_params['search_title'])
                      ->SearchStatus($search_params['search_status'])
                      ->SearchTag($search_params['search_tag'])
                      ->SearchDeadline($search_params['search_deadline_start'], $search_params['search_deadline_end'])
                      ->Sort($search_params['sort_by'])
                      ->paginate(8);


    return view('tasks/index', compact('listings', 'listing', 'tasks', 'search_params'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create(Listing $listing)
  {
    return view('tasks/create', compact('listing'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\TaskRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Listing $listing, TaskRequest $request)
  {
    $task = new Task();

    $task->title = $request->title;
    $task->content = $request->content;
    $task->start_line = $request->start_line;
    $task->dead_line = $request->dead_line;

    $listing->tasks()->save($task);

    $this->CreateCommaSeparatedTags($task, $request);

    return redirect()->route('tasks.index', compact('listing'));
  }

  /**
   * Display the specified resource.
   *
   * @param  Listing  $listing
   * @param  Task  $task
   * @return \Illuminate\Http\Response
   */
  public function show(Listing $listing, Task $task)
  {
    $this->checkRelation($listing, $task);
    return view('tasks/show', compact('task', 'listing'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  Listing  $listing
   * @param  Task  $task
   * @return \Illuminate\Http\Response
   */
  public function edit(Listing $listing, Task $task)
  {
    $this->checkRelation($listing, $task);

    $listings = Auth::user()->listings()->get();
    $listing = $task->listing;

    $tag_array = [];
    foreach ($task->tags as $tag) {
      array_push($tag_array, $tag->name);
    };
    $tags = "";
    if (!empty($tag_array)){
      $tags = implode( ',', $tag_array);
    }

    return view('tasks/edit', compact('task', 'listing', 'listings', 'tags'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param Listing $listing
   * @param Task $task
   * @param TaskRequest $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function update(Listing $listing, Task $task, TaskRequest $request)
  {
    $task->listing_id = $request->listing_id;
    $task->title = $request->title;
    $task->content = $request->content;
    $task->status = $request->status;
    $task->start_line = $request->start_line;
    $task->dead_line = $request->dead_line;
    $task->save();

    $this->CreateCommaSeparatedTags($task, $request);

    $listing = $task->listing;
    return redirect()->route('tasks.index', compact('listing'))->with('message', '更新しました');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param Listing $listing
   * @param  Task  $task
   * @return \Illuminate\Http\Response
   */
  public function destroy(Listing $listing, Task $task)
  {
    $task->delete();

    return redirect()->route('tasks.index', compact('listing'))->with('message', '削除しました');
  }

  private function checkRelation(Listing $listing, Task $task)
  {
    if ($listing->id !== $task->listing_id)
      { 
        abort(404);
      }
  }

  private function CreateCommaSeparatedTags(Task $task, TaskRequest $request)
  {
    $request_tags = explode(',',$request->tags);
    $tags = [];
    foreach ($request_tags as $tag) {
      if (empty($tag)){
        break;
      }
      
      $record = Tag::firstOrCreate(['name' => $tag]);
      array_push($tags, $record);
    }
    $tags_id = [];
    foreach ($tags as $tag) {
      array_push($tags_id, $tag['id']);
    };

    if ($request->isMethod('post')){
      $task->tags()->attach($tags_id);
    } else{
      $task->tags()->sync($tags_id);
    }
  }
}
