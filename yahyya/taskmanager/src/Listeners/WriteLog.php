<?php

namespace Yahyya\taskmanager\Listeners;
use Illuminate\Support\Facades\Log;
use Yahyya\taskmanager\Events\TaskStatusChanged;

class WriteLog
{
    public function handle(TaskStatusChanged $event)
    {
        Log::notice('Task ' . $event->task->title . ' Status was closed!');
    }
}
