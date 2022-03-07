<?php

namespace Yahyya\taskmanager\App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title','desc','user_id','status'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function labels()
    {
        return $this->belongsToMany(Label::class,TaskLabels::class);
    }
}
