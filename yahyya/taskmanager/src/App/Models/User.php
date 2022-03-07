<?php
namespace Yahyya\taskmanager\App\Models;

class User extends \App\User
{

    public function tasks()
    {
        return $this->belongsTo(Task::class);
    }
}
