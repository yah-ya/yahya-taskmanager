<?php

namespace Yahyya\taskmanager\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yahyya\taskmanager\App\Http\Requests\StoreTask;
use Yahyya\taskmanager\App\Http\Requests\UpdateTask;
use Yahyya\taskmanager\App\Interfaces\TaskRepositoryInterface;
use Yahyya\taskmanager\App\Models\Label;
use Yahyya\taskmanager\App\Models\Task;
use Yahyya\taskmanager\App\Models\TaskLabels;
use Yahyya\taskmanager\Events\TaskStatusChanged;

class TaskController extends Controller
{
    private TaskRepositoryInterface $repo;

    public function __construct(TaskRepositoryInterface  $repo)
    {
        $this->repo = $repo;
    }

    public function view(Request $req,$task)
    {
        if(is_numeric($task)){
            $task = Task::findOrFail($task);
        }
        $task = $this->repo->getTaskById($task->id);

        //ToDo : Add policies here?!
        if($task->user_id!=Auth::user()->id)
            return response()->json(['res'=>false,'message'=>'Not Authorized'],403);
        return \Yahyya\taskmanager\App\Http\Resources\Task::make($task);
    }

    public function store(StoreTask $req)
    {
        $details = $req->validated();
        return response()->json(
            [
                'res'=>$this->repo->store($details)
            ]
        );
    }

    public function update(UpdateTask $req,  $task)
    {
        if(is_numeric($task)){
            $task = Task::findOrFail($task);
        }
        return response()->json([
            'res'=> $this->repo->update($task,$req->validated()),
            'data'=>$task
        ]);
    }

    public function toggleStatus( $task)
    {
        if(is_numeric($task)){
            $task = Task::findOrFail($task);
        }
        $res = $this->repo->toggleStatus($task);

        //ToDo : Event should be dispatched when the task status is 1 and going to be closed!
        event(new TaskStatusChanged($task));
        return response()->json([
            'res'=> $res,
            'data'=>$task
        ]);
    }

    public function mergeLabel(Request $req,  $task)
    {

        if(is_numeric($task)){
            $task = Task::findOrFail($task);
        }
        $res = $this->repo->addLabels($task,$req->labels);
        return response()->json([
            'res'=> $res,
            'data'=>$task
        ]);
    }

    public function list()
    {
        return new \Yahyya\taskmanager\App\Http\Resources\TaskCollection($this->repo->list());
    }

    public function listOnlyForThisUser()
    {
        $tasks = $this->repo->getTasksByUser(Auth::user());
        return new \Yahyya\taskmanager\App\Http\Resources\TaskCollection($tasks);
    }
}
