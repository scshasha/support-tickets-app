<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::truncate();

        Category::create(array('name'=>'Emails'));
        Category::create(array('name'=>'Order'));
        Category::create(array('name'=>'Technical'));
        Category::create(array('name'=>'Shipping'));
        Category::create(array('name'=>'Machanical'));
        Category::create(array('name'=>'Uncategorized'));
        
    }
}
