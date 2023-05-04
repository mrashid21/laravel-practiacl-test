<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Form;
use App\Models\Input;

class SurveySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Input::insert([
            [
                'name' => 'name',
                'type' => 'text',
            ],[
                'name' => 'phone_number',
                'type' => 'text',
            ],[
                'name' => 'email',
                'type' => 'email',
            ],[
                'name' => 'date_of_birth',
                'type' => 'date',
            ],[
                'name' => 'transport',
                'type' => 'checkbox',
            ],[
                'name' => 'identification',
                'type' => 'file',
            ],
        ]);

        Form::insert([
            [
                'title' => 'Adidas Forum Mid Parley',
                'description' => 'Good shoes or bad ?',
                'created_by' => User::factory()->create()->id,     
            ],[
                'title' => 'Under Armour vs Nike',
                'description' => 'Which one better running shoes ?',
                'created_by' => User::factory()->create()->id, 
            ]
        ]);

        foreach (Form::get() as $form) {
            $form->inputs()->sync([rand(1,5), rand(1,5)]);
        }
    }
}
