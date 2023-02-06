<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Type;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        Schema::disableForeignKeyConstraints();
        Project::truncate();
        Schema::enableForeignKeyConstraints();

        for( $i = 0; $i < 20; $i++ ) {
            $type = Type::inRandomOrder()->first();
            $new_project = new Project();
            $new_project->project_name = $faker->sentence(3);
            $new_project->client_name = $faker->company();
            $new_project->summary = $faker->text(500);
            $new_project->slug = Str::slug($new_project->project_name, '-');
            $new_project->type_id = $type->id;
            $new_project->save();
        }
    }
}
