<?php
namespace Yahyya\taskmanager\Database\Seeds;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\Yahyya\taskmanager\App\Models\Task::class,100)->create()->each(function($task){
            $task->user_id = \Yahyya\taskmanager\App\Models\User::query()->inRandomOrder()->first()->id;
            $task->labels()->save(\Yahyya\taskmanager\App\Models\Label::query()->inRandomOrder()->first());
        });
    }
}
