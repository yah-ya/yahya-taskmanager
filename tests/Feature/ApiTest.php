<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Yahyya\taskmanager\App\Http\Middleware\CheckAuthToken;
use Yahyya\taskmanager\App\Models\Label;
use Yahyya\taskmanager\App\Models\Task;
use Yahyya\taskmanager\App\Models\User;
use Yahyya\taskmanager\Database\Seeds\LabelSeeder;

class ApiTest extends TestCase
{

    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->withoutMiddleware([CheckAuthToken::class]);

    }

    public function test_user_can_add_new_label()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user,'api')->json('POST','label/new',['title'=>'Test Label']);
        $response->assertStatus(200)->assertJson(['res'=>true]);
    }

    public function test_user_can_add_new_task()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user,'api')->json('POST','task/new',['title'=>'Test Label','user_id'=>$user->id,'status'=>1,'desc'=>'Test Desc']);
        $response->assertStatus(200)->assertJson(['res'=>true]);
    }

    public function test_user_can_edit_a_task()
    {
        $user = factory(User::class)->create();
        $task = factory(Task::class)->create(['user_id'=>$user->id]);

        $response = $this->actingAs($user,'api')->json('POST','tasks/'.$task->id.'/update',['title'=>'Updated','desc'=>'Updated']);

        $task->desc = 'Updated';
        $task->title = 'Updated';

        $response->assertStatus(200)->assertJson(['res'=>true,'data'=>$task->toArray()]);
    }

    public function test_user_can_change_status_of_a_task()
    {
        $user = factory(User::class)->create();
        $task = factory(Task::class)->create(['user_id'=>$user->id]);

        $response = $this->actingAs($user,'api')->json('POST','tasks/'.$task->id.'/status/toggle');

        $task->status = !$task->status;
        $response->assertStatus(200)->assertJson(['res'=>true,'data'=>$task->toArray()]);
    }

    public function test_user_can_add_labels_to_a_task()
    {
        $user = factory(User::class)->create();
        $task = factory(Task::class)->create(['user_id'=>$user->id]);
        $labels = factory(Label::class,30)->create();
        $labels = $labels->map(function($label){
            return $label->id;
        });

        $response = $this->actingAs($user,'api')->json('POST','tasks/'.$task->id.'/labels/add',['labels'=>$labels]);
        $response->assertStatus(200)->assertJson(['res'=>true,'data'=>$task->toArray()]);
    }


    public function test_user_can_get_list_of_labels()
    {
        $user = factory(User::class)->create();
        factory(Label::class,10)->create();
        $response = $this->actingAs($user,'api')->json('GET','labels');
        $this->assertIsArray($response->json()['data']);
        $this->assertEquals(count($response->json()['data']),10);
        $this->assertArrayHasKey('label',$response->json()['data'][0]);
        $this->assertArrayHasKey('id',$response->json()['data'][0]);
        $this->assertArrayHasKey('totalTasks',$response->json()['data'][0]);
        $response->assertStatus(200);
    }

    public function test_user_can_get_list_of_tasks()
    {
        $user = factory(User::class)->create();
        factory(Task::class,10)->create();
        $response = $this->actingAs($user,'api')->json('GET','tasks');
        $this->assertIsArray($response->json()['data']);
        $this->assertEquals(count($response->json()['data']),10);
        $this->assertArrayHasKey('title',$response->json()['data'][0]);
        $this->assertArrayHasKey('description',$response->json()['data'][0]);
        $this->assertArrayHasKey('labels',$response->json()['data'][0]);
        $this->assertIsArray($response->json()['data'][0]['labels']);
        $response->assertStatus(200);
    }


    public function test_user_can_get_details_of_a_task()
    {
        $user = factory(User::class)->create();
        $tasks = factory(Task::class,10)->create(['user_id'=>$user->id]);

        $response = $this->actingAs($user,'api')->json('GET','tasks/'.$tasks[2]->id.'/');
        $response->assertStatus(200);

        //check user can not see others details :

        $users = factory(User::class,10)->create();
        $tasks = factory(Task::class,10)->create(['user_id'=>User::query()->whereNotIn('id',[$user->id])->inRandomOrder()->first()->id]);

        $response = $this->actingAs($user,'api')->json('GET','tasks/'.$tasks[2]->id.'/');
        $response->assertStatus(403);

    }

}