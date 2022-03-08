<?php

namespace Yahyya\taskmanager\App\Repositories;

use Illuminate\Support\Collection;
use Yahyya\taskmanager\App\Interfaces\TaskRepositoryInterface;
use Yahyya\taskmanager\App\Models\Label;
use Yahyya\taskmanager\App\Models\Task;
use Yahyya\taskmanager\App\Models\TaskLabels;
use Yahyya\taskmanager\App\Models\User;

class TaskRepository implements TaskRepositoryInterface
{

    public function store(array $details):bool
    {
        try {
            Task::create($details);
            return true;
        } catch (\Exception $ex){
            print_r($ex->getMessage());
            return false;
        }
    }

    public function list():Collection
    {
        return Task::all();
    }

    public function getTaskById(int $taskId): Task
    {
        return Task::findOrFail($taskId);
    }

    public function update(Task $task, array $details): bool
    {
        $task->update($details);
        return true;
    }

    public function toggleStatus(Task $task): bool
    {
        $task->status = !$task->status;
        $task->save();
        return true;
    }

    public function addLabels(Task $task, $labels): bool
    {
        $taskLabels = [];
        foreach($labels as $l){
            $taskLabels[] = ['label_id'=>$l,'task_id'=>$task->id];
        }

        TaskLabels::insert($taskLabels);
        return true;
    }

    public function getTasksByUser(User $user): Collection
    {
        return Task::where('user_id',$user->id)->get();
    }
}
