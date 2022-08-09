<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // 1 nacin
        $post1 = new Category();
        $post1->name = 'monitori';
        $post1->save();

        // 2 nacin
        DB::table('categories')->insert([
            'name' => 'misevi'
        ]);
    }
}
