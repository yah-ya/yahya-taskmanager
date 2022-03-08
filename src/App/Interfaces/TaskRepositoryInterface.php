<?php

namespace Yahyya\taskmanager\App\Interfaces;

use Illuminate\Support\Collection;
use Yahyya\taskmanager\App\Models\Task;
use Yahyya\taskmanager\App\Models\User;

interface TaskRepositoryInterface
{
    public function getTaskById(int $taskId):Task;
    public function getTasksByUser(User $user):Collection;
    public function store(array $details):bool;
    public function update(Task $task,array $details):bool;
    public function toggleStatus(Task $task):bool;
    public function addLabels(Task $task, $labels):bool;
    public function list():Collection;
}
