<?php
namespace Yahyya\taskmanager\Database\Seeds;
use Illuminate\Database\Seeder;

class LabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\Yahyya\taskmanager\App\Models\Label::class,100)->create()->each(function($label){
        });
    }
}
