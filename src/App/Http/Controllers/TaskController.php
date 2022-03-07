<?php

namespace Yahyya\taskmanager\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yahyya\taskmanager\App\Http\Requests\StoreTask;
use Yahyya\taskmanager\App\Http\Requests\UpdateTask;
use Yahyya\taskmanager\App\Models\Label;
use Yahyya\taskmanager\App\Models\Task;
use Yahyya\taskmanager\App\Models\TaskLabels;
use Yahyya\taskmanager\Events\TaskStatusChanged;

class TaskController extends Controller
{
    public function view(Request $req)
    {
        $task = Task::findOrFail($req->id);
        if($task->user_id!=Auth::user()->id)
            return response()->json(['res'=>false,'message'=>'Not Authorized'],403);
        return \Yahyya\taskmanager\App\Http\Resources\Task::make($task);
    }

    public function store(StoreTask $req)
    {
        try {
            Task::create($req->validated());
            return true;
        } catch (\Exception $ex){
            print_r($ex->getMessage());
            return false;
        }
    }

    public function update(UpdateTask $req,Task $task)
    {
        $task->update($req->validated());
        return true;
    }

    public function toggleStatus(Task $task)
    {
        //ToDo : Event should be dispatched when the task status is 1 and going to be closed!
        event(new TaskStatusChanged($task));

        $task->status = !$task->status;
        $task->save();
        return true;
    }

    public function mergeLabel(Task $task, $labels)
    {

        $taskLabels = [];
        foreach($labels as $l){
            $taskLabels[] = ['label_id'=>$l->id,'task_id'=>$task->id];
        }

        TaskLabels::insert($taskLabels);
        return true;

    }

    public function list()
    {
        return new \Yahyya\taskmanager\App\Http\Resources\TaskCollection(Task::all());
    }

    public function listOnlyForThisUser()
    {
        $tasks = Task::where('user_id',Auth::user()->id)->get();
        return new \Yahyya\taskmanager\App\Http\Resources\TaskCollection($tasks);
    }
}
