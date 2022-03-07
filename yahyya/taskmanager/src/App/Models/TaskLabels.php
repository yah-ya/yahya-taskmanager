<?php
namespace Yahyya\taskmanager\App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskLabels extends Model
{
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function label()
    {
        return $this->belongsTo(Label::class);
    }
}
