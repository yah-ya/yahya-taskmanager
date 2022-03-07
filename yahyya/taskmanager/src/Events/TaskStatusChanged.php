<?php

namespace Yahyya\taskmanager\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Yahyya\taskmanager\App\Models\Task;

class TaskStatusChanged
{
    use Dispatchable,SerializesModels;

    public $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }
}
