<?php

namespace App\Http\Controllers;

use App\Listing;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\TaskRequest;


class TaskController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
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
      $current_listing = $listing;

      // 検索条件の値を取得
      $search_params['search_title'] = $request->input('search_title');
      $search_params['search_status']= $request->input('search_status');
      $search_params['search_deadline_start']= $request->input('search_deadline_start');
      $search_params['search_deadline_end']= $request->input('search_deadline_end');

      // リストに紐づくタスクを取得
      $tasks = $listing->tasks()
                        ->SearchTitle($search_params['search_title'])
                        ->SearchStatus($search_params['search_status'])
                        ->SearchDeadline($search_params['search_deadline_start'], $search_params['search_deadline_end'])
                        ->get();

      return view('tasks/index', compact('listings', 'current_listing', 'tasks', 'search_params'));
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
      $listings = Auth::user()->listings()->get();
      $listing = $task->listing;
      return view('tasks/edit', compact('task', 'listing', 'listings'));
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
}
