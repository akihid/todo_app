<?php

namespace App\Http\Controllers;

use App\Listing;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\TaskRequest;


class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Listing $listing
     * @return \Illuminate\Http\Response
     */
    public function index(Listing $listing)
    {
      
      $listings = Auth::user()->listings()->get();
      
      // リストに紐づくタスクを取得
      $tasks = $listing->tasks()->get();
      $current_listing = $listing;
      
      return view('tasks/index', compact('listings', 'current_listing', 'tasks'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
      return view('tasks/edit', compact('task', 'listing'));
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
      $task->title = $request->title;
      $task->content = $request->content;
      $task->status = $request->status;
      $task->start_line = $request->start_line;
      $task->dead_line = $request->dead_line;
      $task->save();
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
