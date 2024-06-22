<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //check if Category table is empty
        if (Category::count() > 0) {
            return;
        }
        $contents = json_decode(file_get_contents('https://www.hrfactoryapp.com/Home/shipData'), true);
        //insert content to database
        foreach ($contents['categories'] as  $category) {
            $new_category = new Category();
            $new_category->category_plan = null;
            $new_category->name = $category['Name'];
            $new_category->name_ar = $category['NameAr'];
            $new_category->isActive = $category['isActive'];
            $new_category->save();
        }


    }
}
