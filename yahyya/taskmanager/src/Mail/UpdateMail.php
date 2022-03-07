<?php
namespace Yahyya\taskmanager\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Yahyya\taskmanager\App\Models\Task;

class UpdateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function build()
    {
        return $this->subject('Updated Task')->view('taskmanager::emails.update');
    }
}
