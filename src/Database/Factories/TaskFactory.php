<?php

/** @var Factory $factory */

use Yahyya\taskmanager\App\Models\Task;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Task::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'desc' => $faker->shuffleString,
        'user_id'=> \Illuminate\Support\Facades\Auth::check() ?? \Illuminate\Support\Facades\Auth::user()->id,
        'status' => rand(0,1),
    ];
});
