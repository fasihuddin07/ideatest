<?php

namespace App\Http\Controllers;

use App\Mail\TaskAssigned;
use App\Models\Task;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;



class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $task = Task::where('user_id',Auth::user()->id)->where('is_delete',0)->get();
        $users = User::get();
        // dd($task);
        return view('home',compact('task','users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function assigntask(Request $request)
    {
        $task = Task::find($request->task_id);
        $user = User::find($request->assign_user);
        // dd($user->email);
    
        Mail::to($user->email)->send(new TaskAssigned($task));
        
        return redirect('/');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $task = new Task();
        $task->title = $request->title;
        $task->description = $request->description;
        $task->deadline = $request->deadline;
        $task->status = "Incomplete";
        $task->user_id = Auth::User()->id;
        $task->save();
        return redirect('/');

    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        // dd($request);
        $task = Task::find($request->taskId);
        $task->status = $request->status;
        $task->update();
        return response()->json(['message' => 'Task status updated successfully'], 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task,$id)
    {
        // dd("delete");
        $del = Task::find($id);
        $del->is_delete = 1;
        $del->save();
        return redirect('/');
    }
}
