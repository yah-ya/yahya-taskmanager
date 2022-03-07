<?php

namespace Yahyya\taskmanager\Listeners;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Yahyya\taskmanager\Events\TaskStatusChanged;
use Yahyya\taskmanager\Mail\UpdateMail;

class SendEmail
{
    public function handle(TaskStatusChanged $event)
    {
        Log::info('Email Sent');
        Mail::to('y.t.15132@gmail.com')->send(new UpdateMail($event->task));
    }
}
